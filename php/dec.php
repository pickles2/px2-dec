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
	 * DEC変換処理の実行
	 *
	 * Pickles2の状態を参照し、自動的に処理を振り分けます。
	 *
	 * - パブリッシュする場合、DECコメントを削除します。
	 * - プレビューの場合、DECライブラリを埋め込み、URIパラメータからDECの表示・非表示を切り替えられるようにします。
	 *
	 * @param object $px Picklesオブジェクト
	 * @param object $options オプション
	 * @return boolean true
	 */
	public static function exec( $px, $options = null ){
		if( !$px->is_publish_tool() ){
			self::add_auto_dec( $px, $options );
		}else{
			self::trim_dec( $px, $options );
		}

		return true;
	} // exec()

	/**
	 * DECを削除する
	 *
	 * @param object $px Picklesオブジェクト
	 * @param object $options オプション
	 * @return boolean true
	 */
	public static function trim_dec( $px, $options = null ){
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
			if( $html ){
				$ret = $html->find('*[data-dec-block]');
				foreach( $ret as $retRow ){
					$retRow->outertext = '';
				}
				$src = $html->outertext;
			}

			$px->bowl()->replace( $src, $key );
		}

		return true;
	} // trim_dec()


	/**
	 * 自動DEC表示機能を追加する
	 *
	 * URIパラメータ `showDEC` をつけてアクセスすると、自動的にDECが表示されるようになります。
	 *
	 *   例: http://yourdomain.com/abc/def.html?showDEC
	 *
	 * @param object $px Picklesオブジェクト
	 * @param object $options オプション
	 * @return boolean true
	 */
	public static function add_auto_dec( $px, $options = null ){
		$jscode = file_get_contents( __DIR__.'/res/dec.js' );
		$jscode = '<script>'.$jscode.'</script>';

		foreach( $px->bowl()->get_keys() as $key ){
			$src = $px->bowl()->pull( $key );

			// body要素の最後にスクリプトを追加
			if( preg_match( '/<\/body>/is', $src ) ){
				// body要素の閉じタグが見つかる場合、
				// その手前に挿入
				$src = preg_replace('/<\/body>/is', $jscode.'</body>', $src);
			}else{
				// body要素の閉じタグが見つからない場合、
				// コードの最後に追記
				$src .= $jscode;
			}

			$px->bowl()->replace( $src, $key );
		}

		return true;
	} // add_auto_dec()

}
