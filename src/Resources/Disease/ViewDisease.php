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
    $props = $this->getOriginal()['props'];
    $arr = [
      'id'                        => $this->id,
      'name'                      => $this->name,
      'local_name'                => $this->local_name,
      'code'                      => $this->code,
      'classification_disease_id' => $this->classification_disease_id,
      'props'                     => $props == [] ? null : $props
    ];


    return $arr;
  }
}
