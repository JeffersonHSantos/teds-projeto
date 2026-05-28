## Enunciado do Trabalho

O trabalho (em dupla) consiste em desenvolver uma solucao pratica de um sistema informatizado aplicado a uma area de interesse. O trabalho deve atender os seguintes requisitos:

- Ser desenvolvido em PHP com framework Laravel;
- Deve conter uma pagina inicial, permitindo acesso ao Login e Registro;
- Deve conter um dashboard, permitindo acesso aos cadastros atraves de menus;
- Deve conter, ao menos, 3 cadastros (CRUD) basicos, ou seja, sem chaves estrangeiras (FKs);
- Deve conter, ao menos, 1 cadastro (CRUD) contendo FKs;
- Deve ser desenvolvido dentro do padrao MVC apresentado em aula;
- A base de dados deve ser projetada utilizando migrations;
- Ao longo da disciplina novas funcionalidades serao apresentadas e requisitadas como obrigatorias, como paginacao em listagens, tela de pesquisa, criptografia de rotas e utilizacao de componentes de terceiros. No decorrer do semestre, serao disponibilizados momentos para implementar o trabalho pratico em sala de aula, como forma de praticar e aplicar o conhecimento adquirido na solucao solicitada.

A primeira etapa do trabalho: resumo com requisitos + modelagem dos dados, o tema do sistema a ser desenvolvido, e submeter o documento em atividade no Moodle.

# Sistema TEDS - Gerenciamento de Aulas

Sistema web desenvolvido em Laravel para cadastro e consulta de informações acadêmicas, com foco em visualizacao de aulas por data para uso em sala e exibicao em TV.

## Identificacao Academica

- Instituicao: Universidade de Passo Fundo (UPF)
- Curso: Analise e Desenvolvimento de Sistemas (ADS)
- Nivel: 3o nivel
- Disciplina: TEDS - Topicos Especiais em Desenvolvimento de Software I
- Atividade: Pratico 1
- Aluno: Jefferson H. Santos
- Matricula: 210017

## Objetivo do Projeto

Disponibilizar uma aplicacao para:

- Cadastro de cursos, professores, salas e aulas
- Organizacao de aulas por data e horario
- Consulta rapida no dashboard
- Exibicao em modo tela cheia para TV, facilitando a localizacao dos alunos

## Funcionalidades Implementadas

### 1. CRUD de Cursos

- Criar curso
- Listar cursos
- Editar curso
- Excluir curso

### 2. CRUD de Professores

- Criar professor
- Listar professores
- Editar professor
- Excluir professor

### 3. CRUD de Salas

- Criar sala
- Listar salas
- Editar sala
- Excluir sala

### 4. CRUD de Aulas

- Criar aula vinculando sala, curso e professor
- Listar aulas com informacoes relacionais
- Editar aula
- Excluir aula

### 5. Dashboard com Filtro por Data

- Selecao de data
- Exibicao das aulas da data selecionada
- Ordenacao por horario crescente
- Exibicao em formato de tabela para consulta rapida
- Atualizacao automatica do status das aulas no carregamento do painel
- Atualizacao da tabela em tempo real a cada minuto, sem sair da tela cheia

### 6. Modo TV (Tela Cheia)

- Botao para entrar em tela cheia
- Foco somente nas informacoes da tabela
- Exibicao do dia da semana da data selecionada em fullscreen
- Saida da tela cheia pelo atalho do navegador ou pela tecla F11
- Interface com destaque visual por status, incluindo cores nas linhas e nas celulas

### 7. Destaque Visual dos Status

- Coluna de status no dashboard TV com o texto do status atual da aula
- Linhas e celulas com background colorido por status
- Em andamento com destaque mais forte e animacao de cor gradativa
- Agendada e Realizada com cores diferenciadas para facilitar a leitura

### 8. Atualizacao de Status das Aulas

- O sistema sincroniza automaticamente o status das aulas com base no horario atual
- O painel usa o mesmo calculo de status da listagem de aulas para manter consistencia
- O status exibido no dashboard reflete o momento atual sem depender de recarregar a pagina manualmente

## Tecnologias Utilizadas

- PHP 8.3
- Laravel 13
- Blade
- Eloquent ORM
- MySQL ou SQLite (compatibilidade via migrations)
- Tailwind CSS
- Vite
- Node.js + npm

## Estrutura Funcional (Resumo)

- Rotas web em routes/web.php
- Controladores em app/Http/Controllers
- Models em app/Models
- Migrations em database/migrations
- Views Blade em resources/views

## Modelagem de Dados

### Tabela cursos

- id
- nome
- timestamps

### Tabela professors

- id
- nome
- timestamps

### Tabela salas

- id
- nome
- timestamps

### Tabela aulas

- id
- sala_id (FK)
- curso_id (FK)
- professor_id (FK)
- materia
- data
- horario
- timestamps

Relacoes principais:

- Uma aula pertence a uma sala
- Uma aula pertence a um curso
- Uma aula pertence a um professor

## Requisitos para Rodar o Projeto

- PHP 8.3+
- Composer
- Node.js e npm
- Banco de dados configurado no arquivo .env

## Como Executar o Projeto

### 1. Instalar dependencias

```bash
composer install
npm install
```

### 2. Configurar ambiente

```bash
cp .env.example .env
php artisan key:generate
```

No Windows PowerShell, se necessario:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

### 3. Configurar banco e rodar migrations

```bash
php artisan migrate
```

### 4. Subir o projeto em desenvolvimento

Em um terminal:

```bash
php artisan serve
```

Em outro terminal:

```bash
npm run dev
```

Opcional (comando unico do Composer):

```bash
composer run dev
```

## Acesso ao Sistema

- URL local padrao: http://127.0.0.1:8000
- As rotas principais de negocio estao protegidas por autenticacao

## Rotas Principais

- /dashboard
- /cursos
- /professores
- /salas
- /aulas

## Melhorias Realizadas no Frontend

- Padronizacao visual de paginas com layout consistente
- Tabelas no estilo planilha para melhor leitura
- Componentizacao de elementos Blade para reduzir repeticao
- Formularios com mensagens de validacao mais claras

## Autor

Jefferson H. Santos

## Observacao

Este projeto foi desenvolvido para fins academicos, como atividade pratica da disciplina TEDS no curso de ADS da UPF.
