<?php
/**
 * Copyright 2012 Splunk, Inc.
 * 
 * Licensed under the Apache License, Version 2.0 (the "License"): you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once 'StreamStream.php';

class StreamStreamTest extends PHPUnit_Framework_TestCase
{
    public function testRead()
    {
        $content = '<a>b</a>';
        
        $stream = fopen('data://text/plain;base64,' . base64_encode($content), 'rb');
        $streamUri = StreamStream::createUriForStream($stream);
        
        $stream2 = fopen($streamUri, 'rb');
        $this->assertEquals($content, stream_get_contents($stream2));
    }
    
    public function testParseXmlFromMemoryStream()
    {
        $stream = fopen('php://memory', 'rb');
        $streamUri = StreamStream::createUriForStream($stream);
        
        $xmlReader = new XMLReader();
        $xmlReader->open($streamUri);
    }
    
    public function testParseXmlFromHttpStream()
    {
        $stream = fopen('http://en.blog.wordpress.com/feed/', 'rb');
        $streamUri = StreamStream::createUriForStream($stream);
        
        $xmlReader = new XMLReader();
        $xmlReader->open($streamUri);
    }
}