<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TRABALHO TEDS</title>
        <link rel="icon" type="image/png" href="https://upf.br//_uploads/Conteudo/comunicacao/marca/logo-pb-vertical.png">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
        <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 bg-gradient-to-r from-slate-900 to-slate-700 p-6 text-white sm:p-8 rounded-t-2xl">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-300">TRABALHO ACADEMICO</p>
                    <h1 class="mt-2 text-2xl font-bold sm:text-3xl">Sistema TEDS - Gerenciamento de Aulas</h1>
                    <p class="mt-3 text-sm text-slate-200 sm:text-base">
                        Solucao pratica desenvolvida em Laravel para cadastro e exibicao de aulas no curso de ADS da UPF.
                    </p>
                </div>

                <div class="grid gap-6 p-6 sm:p-8 lg:grid-cols-2">
                    <section class="rounded-xl border border-slate-200 bg-slate-50 p-5">
                        <h2 class="text-lg font-semibold text-slate-800">Apresentacao do Projeto</h2>
                        <ul class="mt-4 space-y-2 text-sm text-slate-700">
                            <li><span class="font-semibold">Tema:</span> Sistema informatizado para organizacao de aulas</li>
                            <li><span class="font-semibold">Tecnologia:</span> PHP com framework Laravel</li>
                            <li><span class="font-semibold">Arquitetura:</span> MVC com migrations para banco de dados</li>
                            <li><span class="font-semibold">Modulos:</span> Cursos, Professores, Salas e Aulas</li>
                        </ul>
                    </section>

                    <section class="rounded-xl border border-slate-200 bg-slate-50 p-5">
                        <h2 class="text-lg font-semibold text-slate-800">Apresentacao Academica</h2>
                        <ul class="mt-4 space-y-2 text-sm text-slate-700">
                            <li><span class="font-semibold">Aluno:</span> Jefferson H. Santos</li>
                            <li><span class="font-semibold">Matricula:</span> 210017</li>
                            <li><span class="font-semibold">Curso:</span> Analise e Desenvolvimento de Sistemas (ADS)</li>
                            <li><span class="font-semibold">Faculdade:</span> Universidade de Passo Fundo (UPF)</li>
                            <li><span class="font-semibold">Materia:</span> TEDS - Topicos Especiais em Desenvolvimento de Software I (Pratico 1)</li>
                        </ul>
                    </section>
                </div>

                <div class="border-t border-slate-200 p-6 sm:p-8">
                    <h3 class="text-base font-semibold text-slate-800">Acesso Rapido</h3>
                    <div class="mt-4 flex flex-wrap gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                                    Ir para o painel
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                                    Entrar
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                                        Cadastrar-se
                                    </a>
                                @endif
                            @endauth
                        @endif

                        <a href="{{ route('readme.view') }}" target="_blank" class="inline-flex items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                            Ler README.md
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
