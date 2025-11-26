<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'client_id' => $this->id,
            'owner_user_id' => $this->owner_user_id,
            'userid' => $this->owner_user_id,
            'id' => $this->id,
            'uuid' => $this->uuid,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'fullname' => $this->fullname,
            'companyname' => $this->companyname ?? '',
            'email' => $this->email,
            'address1' => $this->address1 ?? '',
            'address2' => $this->address2 ?? '',
            'city' => $this->city ?? '',
            'fullstate' => $this->state ?? '',
            'state' => $this->state ?? '',
            'postcode' => $this->postcode ?? '',
            'countrycode' => $this->countrycode ?? '',
            'country' => $this->countrycode ?? '',
            'phonenumber' => $this->phonenumber ?? '',
            'tax_id' => $this->tax_id ?? '',
            'email_preferences' => $this->email_preferences ?? [
                'general' => '1',
                'invoice' => '1',
                'support' => '1',
                'product' => '1',
                'domain' => '1',
                'affiliate' => '1',
            ],
            'statecode' => $this->state ?? '',
            'currency' => $this->currency_id,
            'currency_code' => 'USD',
            'defaultgateway' => $this->defaultgateway ?? '',
            'groupid' => $this->groupid,
            'status' => $this->status,
            'credit' => formatCurrencyVNDNoSymbol($this->credit),
            'taxexempt' => $this->taxexempt,
            'latefeeoveride' => $this->latefeeoveride,
            'overideduenotices' => $this->overideduenotices,
            'separateinvoices' => $this->separateinvoices,
            'disableautocc' => $this->disableautocc,
            'emailoptout' => $this->emailoptout,
            'marketing_emails_opt_in' => $this->marketing_emails_opt_in,
            'overrideautoclose' => $this->overrideautoclose,
            'allowSingleSignOn' => $this->allowSingleSignOn,
            'email_verified' => $this->email_verified,
            'language' => $this->language ?? '',
            'isOptedInToMarketingEmails' => $this->isOptedInToMarketingEmails,
            'lastlogin' => $this->lastlogin ?? '',
            'notes' => $this->notes ?? '',
            'customfields' => $this->customFields->map(function ($field) {
                return [
                    'id' => $field->id,
                    'value' => $field->value,
                ];
            }),
            'users' => [
                'user' => $this->users->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'is_owner' => $user->is_owner,
                    ];
                }),
            ],
        ];
    }
}
