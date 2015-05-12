<?php
/**
 * Pickles2 DEC CORE class
 */
namespace tomk79\pickles2\dec;

/**
 * Pickles2 DEC CORE class
 */
class main{
	private $px;

	/**
	 * 変換処理の実行
	 * @param object $px Picklesオブジェクト
	 */
	public static function exec( $px, $options = null ){
		if( !$px->is_publish_tool() ){
			return true;
		}
		require_once(__DIR__.'/simple_html_dom.php');

		foreach( $px->bowl()->get_keys() as $key ){
			$src = $px->bowl()->pull( $key );

			// data-dec属性を削除
			$src = preg_replace('/\s?data\-dec\=\".*?\"/is', '', $src);

			// data-dec-blockブロックを削除
			$html = str_get_html(
				$src ,
				true, // $lowercase
				true, // $forceTagsClosed
				DEFAULT_TARGET_CHARSET, // $target_charset
				false, // $stripRN
				DEFAULT_BR_TEXT, // $defaultBRText
				DEFAULT_SPAN_TEXT // $defaultSpanText
			);
			$ret = $html->find('*[data-dec-block]');
			foreach( $ret as $retRow ){
				$retRow->outertext = '';
			}
			$src = $html->outertext;

			$px->bowl()->replace( $src, $key );
		}

		return true;
	}


}
