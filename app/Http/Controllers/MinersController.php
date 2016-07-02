<?php

	namespace AntControl\Http\Controllers;

	use AntControl\Model\Host;
	use AntControl\Model\RemoteRouterModel;
	use Illuminate\Http\Request;

	use AntControl\Http\Requests;

	class MinersController extends Controller {
		public function index() {

			return view('miners', [
				'hosts' => Host::orderBy('active', 'asc')->orderBy('ip', 'asc')->get(),
				'count' => Host::count(),
			]);
		}

		public function refreshHosts() {
			$remoteRouter = new \AntControl\Model\RemoteRouterModel();

			\AntControl\Model\Host::where(['active' => 1])->update(['active' => 0]);

			foreach ($remoteRouter->getHosts() as $host) {
				$response['mac']    = $host['mac'];
				$response['ip']     = $host['ip'];
				$response['active'] = 1;
				Host::updateOrCreate(
					['mac' => $response['mac']],
					$response
				);
			};

			return redirect('miners');
		}

		public function refreshInfo($id) {
			$remoteRouter = new \AntControl\Model\RemoteRouterModel();
			$host         = Host::find($id);

			if ($response = $remoteRouter->getHostInfo($host->ip)) {
				$host->fill($response);
			} else {
				$host->fill(['active' => 0]);
			}
			$host->save();

			return redirect('miners');
		}
	}
