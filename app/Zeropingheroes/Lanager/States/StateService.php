<?php namespace Zeropingheroes\Lanager\States;

use DB, Carbon\Carbon, Config;

class StateService {

	public function at( $timestamp, $options = [] )
	{
		$defaults = [
			'orderBy'		=> 'states.user_id',
			'with'			=>	[
									'application',
									'server',
									'user',
								],
		];

		$options = array_merge($defaults, $options);
		$start = Carbon::createFromTimeStamp($timestamp-(Config::get('lanager/steam.pollingInterval')));
		$end = Carbon::createFromTimeStamp($timestamp+(Config::get('lanager/steam.pollingInterval')));

		return State::select( 'states.*' )
							->join(
								DB::raw('(
										SELECT max(created_at) max_created_at, user_id
										FROM states
										WHERE created_at
											BETWEEN "'.$start.'"
											AND 	"'.$end.'"
										GROUP BY user_id
										) s2'),
								function($join)
								{
									$join->on('states.user_id', '=', 's2.user_id')
										 ->on('states.created_at', '=', 's2.max_created_at');
								}
							)
							->orderBy( $options['orderBy'] )
							->with( $options['with'] );
	}

}