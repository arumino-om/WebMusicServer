<?php
require_once __DIR__ . "/wms/InitWmsApi.php";
require_once __DIR__ . "/wms/Response.php";
use WmsApi\InitWmsApi, WmsApi\Response;
InitWmsApi::init();

header("Content-Type: application/json;charset=UTF-8");
echo Response::makeApiVersionResponse();
