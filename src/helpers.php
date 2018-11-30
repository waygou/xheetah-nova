<?php

use Illuminate\Support\Facades\Auth;
use Waygou\Xheetah\Models\UserLog;

/*function trans($trans)
{
    return __('xheetah-nova::'.$trans);
}
*/

function langHas($phrase, $lang, $default = 'en')
{
    if (Lang::has($phrase, $lang) == false ||
        Lang::get($phrase, $lang) == Lang::get($phrase, $default)) {
        return false;
    }

    return true;
}

/**
 * Verify if a user has.
 *
 * @param string|array $profileCode Profile codes.
 *
 * @return bool Exist at least in one profile code(s).
 */
function user_is($profileCode)
{
    return Auth::user()->profiles()->whereIn('code', (array) $profileCode)->exists();
}

function save_user_log($model, $action = 'saved')
{
    // Save User Log entry.
    $userLog = new UserLog();
    $userLog->create(['user_id'          => Auth::id(),
                      'action_type'      => $action,
                      'related_model'    => get_class($model),
                      'related_model_id' => $model->id,
                      'payload'          => json_encode($model->getAttributes()),
                    ]);
}
