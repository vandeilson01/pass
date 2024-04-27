<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'document' => $this->document,
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'ip' => $this->ip,
            'email_verified_at' => $this->email_verified_at,
            'last_login_at' => $this->last_login_at,
            'birth_date' => $this->birth_date,
            'pix_key' => $this->pix_key,
            'pix_key_type' => $this->pix_key_type,
            'ref_code' => $this->ref_code,
            'affiliate_percent_revenue_share' => (int) $this->affiliate_percent_revenue_share,
            'affiliate_percent_revenue_share_sub' => (int) $this->affiliate_percent_revenue_share_sub,
            'affiliate_cpa' => (int) $this->affiliate_cpa,
            'affiliate_cpa_sub' => (int) $this->affiliate_cpa_sub,
            'affiliate_min_deposit_cpa' => (int) $this->affiliate_min_deposit_cpa,
            'fake_affiliate_percent_revenue_share' => (int) $this->fake_affiliate_percent_revenue_share,
            'fake_affiliate_percent_revenue_share_sub' => (int) $this->fake_affiliate_percent_revenue_share_sub,
            'fake_affiliate_cpa' => (int) $this->fake_affiliate_cpa,
            'fake_affiliate_cpa_sub' => (int) $this->fake_affiliate_cpa_sub,
            'fake_affiliate_min_deposit_cpa' => (int) $this->fake_affiliate_min_deposit_cpa,
            'affiliate_id' => $this->affiliate_id,
            'roles' => $this->roles->pluck('name'),
            'permissions' => $this->getPermissionsViaRoles()->pluck('name'),
            'created_at' => $this->created_at->format('d/m/Y H:i'),
        ];
    }
}
