<?php

namespace Hanafalah\ModuleDisease\Controllers\API\Illness;

use Hanafalah\ModuleDisease\Contracts\Schemas\Illness;
use Hanafalah\ModuleDisease\Controllers\API\ApiController;
use Hanafalah\ModuleDisease\Requests\API\Illness\{
    ViewRequest, StoreRequest, DeleteRequest
};

class IllnessController extends ApiController{
    public function __construct(
        protected Illness $__illness_schema
    ){
        parent::__construct();
    }

    public function index(ViewRequest $request){
        return $this->__illness_schema->viewIllnessList();
    }

    public function store(StoreRequest $request){
        return $this->__illness_schema->storeIllness();
    }

    public function destroy(DeleteRequest $request){
        return $this->__illness_schema->deleteIllness();
    }
}