<?php

namespace App\Traits\Core;

use Illuminate\Http\Request;

trait TraitUserScope {
    public function scopeFilter($query, Request $request)
    {
        return $query->when($request->has('filter'), function($newQuery) use ($request) {
            return $newQuery->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->filter}%")->orWhere('email', 'like', "%{$request->filter}%");
            });
        });
    }

    public function scopeWithRole($query, $roleId)
    {
        return $query->with(['role' => function($query) use ($roleId) {
            return $query->where('id', $roleId);
        }]);
    }
}