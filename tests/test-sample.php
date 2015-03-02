<?php

class hoge extends WP_UnitTestCase {

	/**
	 * @test
	 */
	function disable_version_check() {
		$this->assertFalse( has_action( 'wp_version_check', 'wp_version_check' ) );
		$this->assertFalse( has_action( 'admin_init', '_maybe_update_core' ) );
		$this->assertSame( 10, has_filter( 'pre_site_transient_update_core', '__return_zero' ) );
		$this->assertSame( true, DISALLOW_FILE_EDIT );
	}

	/**
	 * @test
	 */
	function wp_head_test()
	{
		$this->expectOutputString('');
		my_wp_head();
	}

	/**
	 * @test
	 */
	function wp_head_test2()
	{
		update_option( 'my_option', 1 );

		$this->expectOutputString('<meta>');
		my_wp_head();
	}
}