<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Role Permissions
function hasPermission($permission) {
    if (Auth::user()) {
        if (Auth::user()->role == "admin") {
            return true;
        }
        $id = Auth::user()->id;

        $granted_permissions = User::with('permissions')->where('id', $id)->first();
        $granted_permissions_array = array_column($granted_permissions->permissions->toArray(), 'permission');
        if ($granted_permissions && in_array($permission, $granted_permissions_array)) {
            return true;
        }
    }
    return false;
}
