<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Nursery;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $tenantId = $request->header('X-Tenant-ID');

        if (!$tenantId) {
            return response()->json(['error' => 'Tenant ID header missing'], 400);
        }

        // Resolve all nursery IDs belonging to this tenant
        $nurseryIds = Nursery::where('tenant_id', $tenantId)->pluck('id')->toArray();

        if (empty($nurseryIds)) {
            return response()->json(['error' => 'No nurseries found for tenant'], 403);
        }

        // Attach nursery_ids to request for downstream use
        $request->merge(['nursery_ids' => $nurseryIds]);

        return $next($request);
    }
}
