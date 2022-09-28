# walmart-marketplace-sdk-php
Walmart Marketplace API PHP SDK



#### 批量feed Item

 1. 发送feed item

    1. ```php
       use Walmart\Facades\Items;
       use Walmart\RequestReport\Config;
       ```

    2. ```php
       $config = Config::Init(app name, app id, app secret);
       ```

    3. ```php
       //设置feed header信息
       $header=[];
       $MPItemFeedHeader = Items::MPItemFeedHeaderInit($header);
       ```

    4. ```php
       //设置listing信息
       $listing=[];
       $MPItem[]=Items::MPItemInit($listing);
       ```

    5. ```php
       //发送feed
       $requestParams = new class($MPItemFeedHeader, $MPItem) {
           public function __construct($MPItemFeedHeader, $MPItem)
           {
               $this->MPItemFeedHeader = $MPItemFeedHeader;
               $this->MPItem = $MPItem;
           }
       };
       $feed_id=Items::BulkItemSetup($config, $requestParams);
       
       $feed_id为返回的feed id信息,可以根据此信息去查询feed状态
       ```

2. 检查feed状态

   1. ```PHP
      use Walmart\Facades\Feed;
      ```

   2. ```PHP
      $config = Config::Init(app name, app id, app secret);
      ```

   3. ```PHP
      $feedRes = Feed::getStatusWithDetail($config, $feed_id);
      ```

3. 检查item状态

   1. ```PHP
      use Walmart\Facades\Items;
      ```

   2. ```PHP
      $config = Config::Init(app name, app id, app secret);
      ```

   3. ```PHP
      $sku='店铺信息';
      Items::GetAnItem($config, $sku);
      ```

 4. 修改价格/库存/Item信息

    

#### 库存

 1. 修改库存

    1. ```php
       use Walmart\RequestReport\Config;
       use Walmart\Facades\Inventory;
       ```

    2. ```php
       $config = Config::Init(app name, app id, app secret);
       
       $sku = '店铺SKU';
       $num = '库存';
       Inventory::update($config, $sku, $num);
       ```

#### 价格

 1. 改价

    1. ```php
       use Walmart\Facades\Price;
       use Walmart\RequestReport\Config;
       ```

    2. ```php
       $config = Config::Init(app name, app id, app secret);
       
       $sku='店铺SKU';
       $currency='币种';
       $amount='价格';
       $requestParams = [
           'sku' => $sku,
           'pricing' => [
               [
                   'currentPriceType' => 'BASE',
                   'currentPrice' => [
                       'currency' => $currency,
                       'amount' => $amount
                   ]
               ]
           ]
       ];
       Price::UpdatePrice($config, $requestParams);
       ```

#### 下架

 1. 下架

    1. ```php
       use Walmart\Facades\Items;
       use Walmart\RequestReport\Config;
       ```

    2. ```php
       $config = Config::Init(app name, app id, app secret);
       
       $sku='店铺SKU';
       Items::RetireAnItem($config, $sku);
       ```

#### 预生成报表

 1. 获取报表

    1. ```php
       use Walmart\Facades\MultipleReports;
       use Walmart\RequestReport\Config;
       ```

    2. ```php
       $type='item';
       $config = Config::Init(app name, app id, app secret);
       $response=MultipleReports::GetReport($config, $type);
       
       $response 为二进制文件数据,需要将次数据放入到文件中,可以使用php的fopen(),fwrite(),fclose()操作
       ```

#### On-request 报表

​	**创建报表请求 **

 1. 引入文件

    1. ```php
       use Walmart\RequestReport\RequestReport;
        use Walmart\RequestReport\Config;
       ```

 2. 配置初始化 

    1. ```php
       $config = Config::Init(app name, app id, app secret);
       ```

 3. 创建请求报表:

    1. ```php
       $params = [
                   'reportType' => '',
                   'reportVersion' => '',
                   'rowFilters' => '',
                   'excludeColumns' => '',
               ];
       $response=RequestReport::requestReport($config, $params);
       
       $response['requestId']; //request ID
       $response['requestStatus']; //reqeust status
       $response['requestSubmissionDate'];//reqquest date
       ```

***



​	**检查报表状态**

 1. 引入文件

    1. ```php
       use Walmart\RequestReport\RequestReport;
        use Walmart\RequestReport\Config;
       ```

 2. 配置初始化 

    1. ```php
       $config = Config::Init(app name, app id, app secret);
       ```

 3. 检查报表状态

    1. ```php
       $request_id='创建请求报表中返回的requestid';
       $response=RequestReport::checkReport($config, $request_id);
       
       $response['requestStatus']==='READY' 时,则可以进行下一步操作
       ```

***



​	**下载报表URL,并根据URL下载报表**

 1. 引入文件

    1. ```php
        use Walmart\RequestReport\Config;
       use Walmart\RequestReport\RequestReport;
       ```

 2. 配置初始化 

    1. ```php
       $config = Config::Init(app name, app id, app secret);
       ```

 3. 下载报表URL

    1. ```php
       $request_id='创建请求报表中返回的requestid';
       $response=RequestReport::DownloadReport($config, $request_id);
       $response['downloadURL']; //报表url
       $response['downloadURLExpirationTime']; //报表url的有效期
       ```

    2. ```php
       function mk_tmp_file()
       {
           $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "Reports";
           if (!is_dir($path)) {
               mkdir($path);
           }
           $pathInfo = pathinfo($this->requestReport->download_url);
           $fileName = $pathInfo['filename'];
           $ext = ".zip";
           
           return $path . DIRECTORY_SEPARATOR . $fileName . $ext;
       }
       function download_curl($url, $filename)
       {
           $hander = curl_init();
           $fp = fopen($filename, 'wb');
           curl_setopt($hander, CURLOPT_URL, $url);
           curl_setopt($hander, CURLOPT_FILE, $fp);
           curl_setopt($hander, CURLOPT_HEADER, 0);
           curl_setopt($hander, CURLOPT_FOLLOWLOCATION, 1);
           curl_setopt($hander, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($hander, CURLOPT_TIMEOUT, 60);
           curl_exec($hander);
           curl_close($hander);
           fclose($fp);
           return true;
       }
       function unzip($filename)
       {
           $zip = new \ZipArchive;
           $res = $zip->open($filename);
           if ($res === true) {
               $zip->extractTo($filename);
               $zip->close();
           } else {
               throw new \Exception($res);
           }
       }
       
       $filename=mk_tmp_file();
       download_curl($url,$filename);
       unzip($filename);
       ```

***



