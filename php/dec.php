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

		foreach( $px->bowl()->get_keys() as $key ){
			$src = $px->bowl()->pull( $key );

			// DES属性を削除
			$src = preg_replace('/\s?data\-dec\=\".*?\"/is', '', $src);

			$px->bowl()->replace( $src, $key );
		}

		return true;
	}


}
