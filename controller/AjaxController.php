<?php
/**
* defines behaviour of all Ajax-enabled Controllers
* 
* @author Torsten Oppermann
* @since 19.03.2015
*/
abstract class AjaxController
{
    public abstract function execute($request);
}