<?php 


interface IWebView extends IView {

    function addHeader(Header $header);

    function getHeaders();

    function addHead(HtmlHead $elem);

    function getHeadContent();
}
