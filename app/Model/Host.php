<?php

	namespace AntControl\Model;

	use Illuminate\Database\Eloquent\Model;

	class Host extends Model {
		protected $fillable = ['mac', 'ip', 'ip_static',
			'pool1_url', 'pool1_worker', 'pool1_password',
			'pool2_url', 'pool2_worker', 'pool2_password',
			'pool3_url', 'pool3_worker', 'pool3_password',
			'frequency', 'hw', 'elapsed', 'ghs_5s', 'ghs_avg',
			'temp1', 'temp2', 'fan1', 'fan2', 'fan3', 'fan4',
			'active'];
	}
