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

		public function refreshInfo(Request $request) {

			$remoteRouter = new \AntControl\Model\RemoteRouterModel();
			$host         = Host::find($request->id);

			if ($response = $remoteRouter->getHostInfo($host->ip)) {
				$host->fill($response);
			} else {
				$host->fill(['ghs_5s' => 0, 'ghs_avg' => 0, 'active' => 0]);
			}
			$host->save();

			if ($request->method() == 'POST') {
				return response()->json(['ok' => true]);
			} else {
				return redirect('miners');
			}
		}

		public function switchHost(Request $request) {
			$host = Host::find($request->id);

			(new \AntControl\Model\RemoteRouterModel())->switchHost($host->ip);

			return response()->json(['url' => env('MINER_HOST', 'http://localhost')]);
		}
	}
