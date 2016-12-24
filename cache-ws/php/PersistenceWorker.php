/**
* Persists data into files asyncronously.
*
* @author: shivam.maharshi
*/
<?php

class PersistenceWorker extends Thread {

  private $fname;
  private $data;

  public function __construct($fname, $data) {
    $this->fname = $fname;
    $this->data = $data;
  }

  public function run() {
    file_put_contents($this->fname, $this->data);
  }

}

?>
