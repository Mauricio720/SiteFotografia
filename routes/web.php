<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Auth::routes();

Route::prefix('painel')->group(function(){
    Route::get('/','Admin\HomeController@index')->name('admin');
    
    Route::get('/permissoes','Admin\PermissoesController')->name('permissoes');
    
    Route::get('/login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Admin\Auth\LoginController@login');
    Route::get('/logout', 'Admin\Auth\LoginController@logout')->name('sair');
    
    // Registration Routes...
    Route::get('/register', 'Admin\Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'Admin\Auth\RegisterController@register');
    
    // Password Reset Routes...
    Route::get('/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset', 'Admin\Auth\ResetPasswordController@reset');
    
    Route::get('/lembrarSenha', 'Admin\UsuariosController@lembrarSenhaView')->name('lembrarSenha');
    Route::post('/lembrarSenha', 'Admin\UsuariosController@lembrarSenha')->name('lembrarSenha');
    Route::get('/atualizarSenhaRelembrar/{hash}', 'Admin\UsuariosController@atualizarSenhaRelembrar')->name('atualizarSenhaRelembrar');

    Route::post('/config','Admin\ConfigSiteController@atualizarConfigMenus')->name('salvarConfig');
    
    Route::get('/portfolio','Admin\FotoController')->name('portfolioPainel');
    Route::get('/foto/{idFoto}/{idTela}','Admin\FotoController@marcarDesmarcarComoFavorita')->name('marcarDesmarcarFoto');
    Route::post('/addCategoria','Admin\FotoController@adicionarCategoria')->name('addCategoria');
    
    Route::get('/addAlbum/{idCategoria}','Admin\FotoController@addAlbumView')->name('addAlbumView');
    Route::get('/excluirCategoria/{idCategoria}','Admin\FotoController@excluirCategoria')->name('excluirCategoria');
    Route::post('/addAlbum','Admin\FotoController@addAlbum')->name('addAlbum');
    Route::get('/excluirAlbum/{idAlbum}','Admin\FotoController@excluirAlbum')->name('excluirAlbum');
    Route::get('/editarAlbum/{idAlbum}','Admin\FotoController@editAlbumView')->name('editarAlbumView');
    Route::post('/editarAlbum','Admin\FotoController@editarAlbum')->name('editarAlbum');
    
    Route::get('/fotos/{idAlbum}','Admin\FotoController@fotosAlbumView')->name('fotosAlbum');
    Route::post('/addFoto','Admin\FotoController@addFoto')->name('addFoto');
    Route::get('/excluirFoto/{idFoto}','Admin\FotoController@excluirFoto')->name('excluirFoto');

    Route::get('/meuPerfil','Admin\UsuariosController')->name('meuPerfilPainel')->middleware('auth');
    Route::get('/usuarios','Admin\UsuariosController@allUsuariosView')->name('usuariosPainel')->middleware('auth');
    Route::post('/cadastrar','Admin\UsuariosController@cadastrarUsuario')->name('cadastrarUsuario')->middleware('auth');
    Route::get('/ativarConta/{hash}','Admin\UsuariosController@ativarConta')->name('ativarContaUsuario');
    Route::post('/atualizarSenha','Admin\UsuariosController@atualizarSenha')->name('atualizarSenha');
    Route::post('/editarUsuario','Admin\UsuariosController@editarUsuario')->name('editarUsuario')->middleware('auth');
    Route::get('/excluirUsuario/{idUsuario}','Admin\UsuariosController@deleteUsuario')->name('deletarUsuario')->middleware('auth');
    Route::get('/mudarPermissao/{usuario}','Admin\UsuariosController@mudarPermissaoView')->name('mudarPermissaoView')->middleware('auth');
    Route::post('/atualizarPermissao','Admin\UsuariosController@atualizarPermissoes')->name('atualizarPermissao')->middleware('auth');

    Route::get('/eventos',"Admin\EventosController")->name('eventosPainel');
    Route::get('/eventosNotificacao/{idEvento}',"Admin\EventosController@mostrarTelaPorNotificacao")->name('eventosPainelNotificacao');

    Route::get('/marcarDesmarcareventos/{idEvento}',"Admin\EventosController@marcarDesmarcarEvento")->name('marcarDesmarcarEvento');
    Route::post('/eventos',"Admin\EventosController@pesquisarPorClienteOuData")->name('pesquisarPorClienteOuData');

    Route::get('/clientes',"Admin\ClienteController")->name('clientesPainel');
    Route::get('/clientes/{idCliente}',"Admin\ClienteController@clientesViewNotificacao")->name('clientesPainelNotificacao');
    Route::get('/clientesEbook',"Admin\ClienteController@clienteEbookView")->name('clientesViewEbook');
    Route::get('/clientesEbook/{idClienteEbook?}',"Admin\ClienteController@clienteEbookView")->name('clientesViewEbookNotificacao');
    Route::get('/clientesEbook/{idClienteEbook?}/{idArquivoArtigo?}',"Admin\ClienteController@clienteEbookView")->name('clientesViewEbookNotificacao');
    
    Route::get('/clientesDepoimentos','Admin\ClienteController@depoimentosView')->name('depoimentosView');
    Route::post('/clientesAddDepoimento','Admin\ClienteController@addDepoimento')->name('addDepoimento');
    Route::post('/clientesEditDepoimento','Admin\ClienteController@editDepoimento')->name('editDepoimento');
    Route::get('/clientesDeleteDepoimento/{idDepoimento}','Admin\ClienteController@excluirDepoimento')->name('excluirDepoimento');


    Route::post('/clientes',"Admin\ClienteController@clientesPesquisar")->name('clientesPesquisa');
    Route::post('/clientesEbookPesquisa',"Admin\ClienteController@clienteEbookPesquisar")->name('clientesPesquisaEbook');

    
    Route::get('/artigos','Admin\ArtigosController')->name('artigosPainel');
    Route::get('/meusartigos','Admin\ArtigosController@meusArtigos')->name('meusArtigosPainel');
    Route::post('/cadastrarArtigos','Admin\ArtigosController@cadastrarArtigo')->name('cadastrarArtigo');
    Route::post('/cadastrarArquivoArtigo','Admin\ArtigosController@addArquivoArtigo')->name('cadastrarArquivoArtigo');
    Route::post('/editarArquivoArtigo','Admin\ArtigosController@editarArquivosArtigos')->name('editarArquivoArtigo');
    Route::get('/excluirArquivoArtigo/{idArquivoArtigo}','Admin\ArtigosController@excluirArquivosArtigos')->name('excluirArquivosArtigos');
    Route::get('/baixarArquivo/{slugArtigo}/{nomeArquivo}','Admin\ArtigosController@baixarArquivoArtigo')->name('baixarArquivoArtigo');

    Route::post('/editarArtigo','Admin\ArtigosController@atualizarArtigo')->name('atualizarArtigo');
    Route::get('/excluirArtigos/{idArtigo}','Admin\ArtigosController@excluirArtigo')->name('excluirArtigo');
    Route::get('/verArtigo/{idArtigo}','Admin\ArtigosController@verArtigo')->name('verArtigo');
    Route::get('/verArtigoCriacao/{idArtigo}','Admin\ArtigosController@verArtigoCriacao')->name('verArtigoCriacao');
    Route::get('/verArtigoNotificacao/{idArtigo}','Admin\ArtigosController@verArtigoNotificacao')->name('verArtigoNotificacao');
    Route::get('/verArtigoNotificacaoObservacao/{idArtigo}','Admin\ArtigosController@verArtigoNotificacaoObservacao')->name('verArtigoNotificacaoObservacao');
    
    Route::post('/artigos','Admin\ArtigosController@pesquisarArtigo')->name('pesquisarArtigo');
    Route::post('/meusartigos','Admin\ArtigosController@pesquisarArtigoPorUsuario')->name('pesquisarArtigoPorUsuario');
    Route::post('/atualizarHtmlArtigo','Admin\ArtigosController@atualizarHtmlArtigo')->name('atualizarHtmlArtigo');
    Route::post('/atualizarStatusArtigo','Admin\ArtigosController@atualizarStatusArtigo')->name('atualizarStatusArtigo');
    
    Route::get('/seo','Admin\SeoController')->name('seoView');
    Route::post('/seo','Admin\SeoController@atualizarSeo')->name('atualizarSeo');

    Route::post('/enviarEmail','Admin\UsuariosController@enviarCodigoConfirmacaoEmail')->name('enviarEmailConfirmacao');
});

    Route::prefix('/')->group(function(){
    Route::get('/', 'Site\HomeController@index')->name('homeSite');
    Route::get('/allPicture','Site\FotoController@getAllFavoritePictures')->name('foto.allFavoritePicture');
    Route::get('/historias','Site\FotoController')->name('foto.portfolio');
    Route::post('/albumLike','Site\FotoController@likeAlbum')->name('albumLike');
    Route::post('/albumDeslike','Site\FotoController@deslikeAlbum')->name('albumDeslike');

    Route::get('/historias/{slugCategoria}/{slugAlbum}','Site\FotoController@picturesFromAlbum')->name('foto.album');
    Route::get('/marcos','Site\SobreController')->name('sobre');
    Route::get('/contato','Site\ContactController')->name('contato');
    Route::post('/contato','Site\ContactController@cadastrarEventoECliente')->name('cadastrarEvento');
    Route::get('/blog/{slugArtigo}/{notificacaoArtigo?}','Site\ArtigosController@verArtigo')->name('verArtigoSite');
    
    Route::get('/blog','Site\ArtigosController')->name('artigosSite');
    
    Route::get('/clienteEbook/{nomeArquivo}','Site\ClienteController@clienteEbook')->name('clienteEbook');
    Route::post('/clienteEbook','Site\ClienteController@cadastrarClienteEbook')->name('cadastrarClienteEbook');
    Route::get('/baixarArquivoArtigo/{nomeArquivo}','Site\ClienteController@baixarArquivoView')->name('baixarArquivoView');
    Route::get('/baixarArquivo/{nomeArquivo}','Site\ClienteController@baixarArquivoArtigo')->name('baixarArquivoArtigo');

});

/*Route::get('/',function(){
    return view('Site.embreve');
});*/

/*Route::get('/foo', function () {
Artisan::call('storage:link');
});*/
