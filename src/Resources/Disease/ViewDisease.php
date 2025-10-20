<?php

namespace Hanafalah\ModuleDisease\Resources\Disease;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewDisease extends ApiResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $arr = [
      'id'                        => $this->id,
      'parent_id'                 => $this->parent_id,
      'name'                      => $this->name,
      'flag'                      => $this->flag,
      'local_name'                => $this->local_name,
      'code'                      => $this->code,
      'version'                   => $this->version,
      'classification_disease_id' => $this->classification_disease_id,
    ];
    return $arr;
  }
}
