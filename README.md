## PHP ile İşbank Web Servisleri 
İşbank web servislerinin PHP ile kullanımını kolaylaştıran bir kütüphane. 


### Requirements 
* php: >=7.0
* guzzlehttp/guzzle: ^6.3

### Todo 
* Auto currency code conversion. (TL to 949, USD to 840, etc.)
* Test Cases
* Validations: card number (Pan), urls, expireDate, etc.. 

#### Merchant Ayarları (opsiyonel)
`merchantId` ve `merchantPassword` parametreleri global config objesinde birkez yada her servis başına ayrı ayrı set edilebilir. 
```
IsbankConfig::set('merchantId', '12345');
IsbankConfig::set('merchantPassword', '12345');
```

#### MPI Enrollment
```
$service = new \Teknasyon\Isbank\Services\MpiEnrollment\MpiEnrollmentService();

$service->params()
    ->setPurchaseAmount(0.01)
    ->setCurrency(949)
    ->setPan(51xxxxxxxxxx5531)
    ->setExpiryDate(2205) // YYMM
    ->setBrandName('mastercard') 
    ->setSuccessUrl('http://127.0.0.1/OK')
    ->setFailureUrl('http://127.0.0.1/ERROR')
    ->setRequestId('unique-request-id'); // verifyEnrollmentRequestId 

$response = $service->makeRequest()->getResponse();
echo $response->Status . PHP_EOL; // Y/N/E 

```

#### Virtual POS
```
$data = []; // MPI success callback parametreleri ile dolu oldugunu farz edelim. 

$service = new \Teknasyon\Isbank\Services\VirtualPos\VirtualPosService();

$service->params()
    ->setEci($data['ECI']) // MPI'dan donen ECI
    ->setCavv($data['CAVV']) // MPI'dan donen Cavv
    ->setPan($data['Pan'])
    ->setExpiry(20 . $data['Expiry']) // YYYYMM
    ->setCvv(CARD_CVV) // callback gelene kadar session'da saklanmis olmali. 
    ->setCurrencyAmount(0.01) // 
    ->setCurrencyCode(949) // TL: 949
    ->setMpiTransactionId($data['VerifyEnrollmentRequestId']) 
    ->setTransactionId($data['VerifyEnrollmentRequestId']); 

$response = $service->makeRequest()->getResponse();

var_dump($response->isSuccessfull()); // true/false 
```