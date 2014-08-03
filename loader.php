<?php
/*
Plugin Name: Link shield
Plugin URI: http://wangdev.com/
Description: Replace the URL base of the communication media who are members of CEDRO and AEDE
Version: 0.4.0
Author: José Conti
Author URI: http://www.joseconti.com
License: GPL2 or later
*/

	$aede_domains = array (	'abc.es',
							'abcdesevilla.es',
							'aede.es',
							'as.com',
							'canarias7.es',
							'cincodias.com',
							'deia.com',
							'diaridegirona.cat',
							'diaridetarragona.com',
							'diarideterrassa.es',
							'diariocordoba.com',
							'diariodeavila.es',
							'diariodeavisos.com',
							'diariodeburgos.es',
							'diariodecadiz.es',
							'diariodeibiza.es',
							'diariodejerez.es',
							'diariodelaltoaragon.es',
							'diariodeleon.es',
							'diariodemallorca.es',
							'diariodenavarra.es',
							'diariodesevilla.es',
							'diarioinformacion.com',
							'diariojaen.es',
							'diariopalentino.es',
							'diariovasco.com',
							'eladelantado.com',
							'elcomercio.es',
							'elcorreo.com',
							'elcorreoweb.es',
							'eldiadecordoba.es',
							'eldiariomontanes.es',
							'eleconomista.es',
							'elmundo.es',
							'elpais.com',
							'elpais.es',
							'elperiodico.com',
							'elperiodicodearagon.com',
							'elperiodicoextremadura.com',
							'elperiodicomediterraneo.com',
							'elprogreso.es',
							'elprogreso.galiciae.com',
							'europasur.es',
							'expansion.com',
							'farodevigo.es',
							'gaceta.es',
							'granadahoy.com',
							'heraldo.es',
							'heraldodesoria.es',
							'hoy.es',
							'huelvainformacion.es',
							'ideal.es',
							'intereconomia.com',
							'lagacetadesalamanca.es',
							'laopinion.es',
							'laopinioncoruna.es',
							'laopiniondemalaga.es',
							'laopiniondemurcia.es',
							'laopiniondezamora.es',
							'laprovincia.es',
							'larazon.es',
							'larioja.com',
							'lasprovincias.es',
							'latribunadeciudadreal.es',
							'latribunadetalavera.es',
							'latribunadetoledo.es',
							'lavanguardia.com',
							'laverdad.es',
							'lavozdealmeria.es',
							'lavozdegalicia.es',
							'lavozdigital.es',
							'levante-emv.com',
							'lne.es',
							'majorcadailybulletin.es',
							'majorcadailybulletin.com',
							'malagahoy.es',
							'marca.com',
							'mundodeportivo.com',
							'noticiasdealava.com',
							'noticiasdegipuzkoa.com',
							'regio7.cat',
							'sport.es',
							'superdeporte.es',
							'ultimahora.es',
						);
// load functions

	function link_shield_init(){
		if (function_exists('load_plugin_textdomain')) {
			$plugin_dir = basename(dirname(__FILE__));
			load_plugin_textdomain('link-shield', false, $plugin_dir . "/languages/" );
		}
	}
	add_action('init', 'link_shield_init');

	include_once('link-shield.php');

	function link_shield_buddypress_init() {
    	require( dirname( __FILE__ ) . '/buddypress-link-shield.php' );
	}
	add_action( 'bp_include', 'link_shield_buddypress_init' );

	if ( class_exists( 'bbPress' ) ) {
		require( dirname( __FILE__ ) . '/bbpress-link-shield.php' );
	}
?>