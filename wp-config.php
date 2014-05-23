<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/srv/www/leilao/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'leilao');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'leilao');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '?0o9i8u7y6t');

/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'gW:.s):35;n)C>C6W|@L-`Z5HIGxythJk6Jk&S+rS-q8SC$$zPi+,0w-O%ZVLRE ');
define('SECURE_AUTH_KEY',  ':&tlU ID[IBwVfdojgiK$ArLY|zE`|*KBw93:cft |sH{:LB||5 y_2XR+`ChXs8');
define('LOGGED_IN_KEY',    'ErEf^HbD/Y-2|+El}4}?xnyQ3-UstrE6NV7EGs^DXJS)EGnB9}ERJZu&M]K9}g]_');
define('NONCE_KEY',        '8M.~MZ=TG_K(68ph+A`EX@>SkBDz>z!%ff&+J_V=^Ed-PiH-g`?+]$7fVHWXkW5y');
define('AUTH_SALT',        '_zsF- cHR 8uU|)TrBduq^dy$Ar%#c4REP3+JGJg7,v/!#` ea+ww@g_PO<d:=4/');
define('SECURE_AUTH_SALT', 'VjNXLzZ*1r)@G)kXf|]*m}+RH[]v`5Fr2B108O`+pBJcSk`+.Yq7%8f,Gx&ZO3sD');
define('LOGGED_IN_SALT',   '+4NUh-?4/bIo[R!LKmrddO373x`x(5*H#][Vfi#}ZniInRVuSL2..`4A@PcVKSnu');
define('NONCE_SALT',       '7Z ;.2# N%],)PH+WklO3_]H9AuyUKm^21AFCR<j47/|fp?hYULd`Q10-_W<,*$6');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * O idioma localizado do WordPress é o inglês por padrão.
 *
 * Altere esta definição para localizar o WordPress. Um arquivo MO correspondente ao
 * idioma escolhido deve ser instalado em wp-content/languages. Por exemplo, instale
 * pt_BR.mo em wp-content/languages e altere WPLANG para 'pt_BR' para habilitar o suporte
 * ao português do Brasil.
 */
define('WPLANG', 'pt_BR');

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
