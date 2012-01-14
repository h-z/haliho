<?php 


interface IWebView extends IView {

    function addHeader(IHeader $header);

    function getHeaders();

    function addHead(IHeadElement $elem);

    function getHeadContent();
}
