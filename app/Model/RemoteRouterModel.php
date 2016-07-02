<?php

	namespace AntControl\Model;

	use Illuminate\Database\Eloquent\Model;

	class RemoteRouterModel extends Model {

		public function getHosts() {
			$ch = curl_init(env('REMOTE_HOST','http://localhost') . '/userRpm/LanArpBindingListRpm.htm');
			curl_setopt_array($ch, [
				CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
				CURLOPT_USERPWD        => env('REMOTE_AUTH',''),
				CURLOPT_REFERER        => env('REMOTE_HOST','http://localhost') . '/userRpm/MenuRpm.htm',
				CURLOPT_RETURNTRANSFER => true,
			]);
			$response = curl_exec($ch);

			$start_str = 'var arpClientListDyn = new Array(';

			$start = mb_strpos($response, $start_str) + mb_strlen($start_str);
			$end   = mb_strpos($response, ');', $start);

			$table = mb_substr($response, $start, $end - $start);

			$result = [];
			foreach (explode("\n", $table) as $row) {
				$row = str_getcsv($row);
				$row = array_filter($row, function ($a) {
					if (empty($a)) return false;
					if ($a == '0 ') return false;

					return true;
				});
				if (empty($row)) continue;
				unset($row[3]);
				$result[] = [
					'mac' => $row[1],
					'ip'  => $row[2],
				];
			}


			return $result;
		}

		public function getHostInfo($ip) {
			$ch = curl_init(env('REMOTE_HOST','http://localhost') . '/userRpm/VirtualServerRpm.htm?ExPort=8081&InPort=80&Ip=' . $ip . '&Protocol=2&State=1&Commonport=0&Changed=1&SelIndex=0&Page=1&Save=%D0%A1%D0%BE%D1%85%D1%80%D0%B0%D0%BD%D0%B8%D1%82%D1%8C');
			curl_setopt_array($ch, [
				CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
				CURLOPT_USERPWD        => env('REMOTE_AUTH',''),
				CURLOPT_REFERER        => env('REMOTE_HOST','http://localhost') . '/userRpm/VirtualServerRpm.htm?Modify=0&Page=1',
				CURLOPT_RETURNTRANSFER => true,
			]);
			curl_exec($ch);

			$ch = curl_init(env('MINER_HOST','http://localhost') . '/cgi-bin/minerStatus.cgi');
			curl_setopt_array($ch, [
				CURLOPT_HTTPAUTH       => CURLAUTH_DIGEST,
				CURLOPT_USERPWD        => env('MINER_AUTH',''),
				CURLOPT_REFERER        => env('MINER_HOST','http://localhost') . '/cgi-bin/minerStatus.cgi',
				CURLOPT_RETURNTRANSFER => true,
			]);

			if (!$response = curl_exec($ch)) return false;

			$result = [];

			$html = new \Htmldom($response);

			$result['elapsed'] = $html->find('#ant_elapsed', 0)->innertext;

			$result['ghs_5s']  = str_replace(',', '', $html->find('#ant_ghs5s', 0)->innertext);
			$result['ghs_avg'] = str_replace(',', '', $html->find('#ant_ghsav', 0)->innertext);

			$result['fan1'] = str_replace(',', '', $html->find('#ant_fan1', 0)->innertext);
			$result['fan2'] = str_replace(',', '', $html->find('#ant_fan2', 0)->innertext);
			$result['fan3'] = str_replace(',', '', $html->find('#ant_fan3', 0)->innertext);
			$result['fan4'] = str_replace(',', '', $html->find('#ant_fan4', 0)->innertext);

			$result['hw']    = $html->find('#cbi-table-1-url', 4)->innertext;
			$result['temp1'] = $html->find('#cbi-table-1-temp', 0)->innertext;
			$result['temp2'] = $html->find('#cbi-table-1-temp', 1)->innertext;

			$ch = curl_init(env('MINER_HOST','http://localhost') . '/cgi-bin/minerConfiguration.cgi');
			curl_setopt_array($ch, [
				CURLOPT_HTTPAUTH       => CURLAUTH_DIGEST,
				CURLOPT_USERPWD        => env('MINER_AUTH',''),
				CURLOPT_REFERER        => env('MINER_HOST','http://localhost') . '/cgi-bin/minerConfiguration.cgi',
				CURLOPT_RETURNTRANSFER => true,
			]);
			if (!$response = curl_exec($ch)) return false;

			$start_str = 'ant_data = ';

			$start = mb_strpos($response, $start_str) + mb_strlen($start_str);
			$end   = mb_strpos($response, ';', $start);

			$table = json_decode(mb_substr($response, $start, $end - $start), true);

			$result['pool1_url']      = $table['pools'][0]['url'];
			$result['pool1_worker']   = $table['pools'][0]['user'];
			$result['pool1_password'] = $table['pools'][0]['pass'];

			$result['pool2_url']      = $table['pools'][1]['url'];
			$result['pool2_worker']   = $table['pools'][1]['user'];
			$result['pool2_password'] = $table['pools'][1]['pass'];

			$result['pool3_url']      = $table['pools'][2]['url'];
			$result['pool3_worker']   = $table['pools'][2]['user'];
			$result['pool3_password'] = $table['pools'][2]['pass'];

			$freq = explode(':', $table['bitmain-freq']);

			$result['frequency'] = $freq[1];

			$ch = curl_init(env('MINER_HOST','http://localhost') . '/cgi-bin/get_network_info.cgi');
			curl_setopt_array($ch, [
				CURLOPT_HTTPAUTH       => CURLAUTH_DIGEST,
				CURLOPT_USERPWD        => env('MINER_AUTH',''),
				CURLOPT_REFERER        => env('MINER_HOST','http://localhost') . '/network.html',
				CURLOPT_RETURNTRANSFER => true,
			]);

			if (!$response = curl_exec($ch)) return false;

			$response = json_decode($response, true);

			$result['ip_static'] = $response['nettype'] == 'Static' ? 1 : 0;

			return $result;
		}
	}
