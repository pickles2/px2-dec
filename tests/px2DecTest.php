<?php
/**
 * test for tomk79\PxFW-2.x
 * 
 * $ cd (project dir)
 * $ ./vendor/phpunit/phpunit/phpunit picklesTest "./px-files/_sys/tests/picklesTest.php"
 */

class picklesTest extends PHPUnit\Framework\TestCase{
	private $fs;

	public function setup() : void{
		mb_internal_encoding('UTF-8');
		$this->fs = new tomk79\filesystem();
	}


	/**
	 * 普通に実行してみるテスト
	 */
	public function testStandard(){
		$output = $this->passthru( [
			'php',
			__DIR__.'/testdata/src_px2/.px_execute.php' ,
			'-u' ,
			'Mozilla/5.0' ,
			'/' ,
		] );
		// var_dump($output);
		$this->assertTrue( $this->common_error( $output ) );
		$this->assertEquals( 1, preg_match('/'.preg_quote('data-dec=', '/').'/is', $output) );

	}

	/**
	 * パブリッシュツールとして実行
	 */
	public function testAsPublishTool(){

		$output = $this->passthru( [
			'php',
			__DIR__.'/testdata/src_px2/.px_execute.php' ,
			'-u' ,
			'Mozilla/5.0 (PicklesCrawler)' ,
			'/' ,
		] );
		// var_dump($output);
		$this->assertEquals( 0, preg_match('/'.preg_quote('data-dec=', '/').'/is', $output) );

		// 後始末
		$output = $this->passthru( [
			'php', __DIR__.'/testdata/src_px2/.px_execute.php', '/?PX=clearcache'
		] );

		clearstatcache();
		$this->assertTrue( $this->common_error( $output ) );
		$this->assertTrue( !is_dir( __DIR__.'/testdata/src_px2/caches/p/' ) );

	}






	/**
	 * PHPがエラー吐いてないか確認しておく。
	 */
	private function common_error( $output ){
		if( preg_match('/'.preg_quote('Fatal', '/').'/si', $output) ){ return false; }
		if( preg_match('/'.preg_quote('Warning', '/').'/si', $output) ){ return false; }
		if( preg_match('/'.preg_quote('Notice', '/').'/si', $output) ){ return false; }
		return true;
	}


	/**
	 * コマンドを実行し、標準出力値を返す
	 * @param array $ary_command コマンドのパラメータを要素として持つ配列
	 * @return string コマンドの標準出力値
	 */
	private function passthru( $ary_command ){
		$cmd = array();
		foreach( $ary_command as $row ){
			$param = '"'.addslashes($row).'"';
			array_push( $cmd, $param );
		}
		$cmd = implode( ' ', $cmd );
		ob_start();
		passthru( $cmd );
		$bin = ob_get_clean();
		return $bin;
	}

}
