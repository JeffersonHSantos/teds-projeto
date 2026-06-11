## Sistema TEDS - Documentação Completa

Sistema web em Laravel para gerenciar cursos, salas, professores e aulas, com foco em exibição de aulas por data (painel/TV) e controle automático de status por horário.

---

## Conteúdo desta documentação

- Visão geral e objetivo
- Funcionalidades principais
- Modelos e migrações (colunas essenciais)
- Controladores e comportamentos importantes
- Rotas relevantes
- Views (onde o horário aparece)
- Formatos de dados e regras (datas/horários)
- Comandos úteis e manutenção (cache/views)
- Como executar localmente
- Testes

---

## Visão geral

O sistema oferece CRUDs para `cursos`, `professores`, `salas` e `aulas`. A funcionalidade central é o painel (`/dashboard`) que exibe as aulas de uma data selecionada, com modo tela-cheia (TV) e atualização automática a cada minuto.

## Funcionalidades principais

- CRUD completo para Cursos, Professores e Salas
- CRUD de Aulas vinculando Sala, Curso e Professor
- Validação de conflitos de horário (mesma sala/professor em conflito)
- Dashboard com filtro por data, ordenação por `horario_inicio` e destaque visual por status
- Modo TV (tela cheia) com auto-refresh e atalho F11
- Filtros avançados (por sala, curso, professor, matéria, status, intervalos de data e horário)

## Modelos e migrações

- `app/Models/Aula.php`
	- Campos importantes (`$fillable`): `sala_id`, `curso_id`, `professor_id`, `materia`, `data`, `horario`, `horario_inicio`, `horario_termino`, `status`
	- Accessor: `getHorarioFormatadoAttribute()` retorna `HH:MM - HH:MM` ou `HH:MM` conforme disponível.
	- Método estático `atualizarStatusAutomatico()` calcula e persiste o status das aulas com base em `data`, `horario_inicio` e `horario_termino`.

- Migração inicial: `database/migrations/2026_04_26_173310_create_aulas_table.php` cria `data` (date) e `horario` (string).
- Migração de aprimoramento: `database/migrations/2026_05_27_000000_add_horario_inicio_e_termino_to_aulas_table.php` adiciona `horario_inicio` e `horario_termino` (`time`, nullable).

Observação: `horario` é mantido como campo legível (ex.: "08:30 - 09:20") e `horario_inicio`/`horario_termino` são usados para comparações/ordenação/cálculos.

## Controladores e regras importantes

- `app/Http/Controllers/AulaController.php`
	- `index`: atualiza status via `Aula::atualizarStatusAutomatico()` e lista aulas.
	- `create` / `edit`: retornam views com relações (salas, cursos, professores).
	- `store` / `update`: validam campos (`date` para `data` e `date_format:H:i` para horários), convertem `H:i` para `H:i:s` para armazenamento em `horario_inicio`/`horario_termino` e populam `horario` (string) com `substr()`.
	- `validarConflitosHorario`: verifica conflitos por sobreposição (professor/sala) para a mesma `data`.

## Regras de status das aulas

- Estados: `AGENDADA`, `EM_ANDAMENTO`, `REALIZADA`, `CANCELADA`.
- Lógica (em `Aula::statusAtual()`):
	- Se `status` for `CANCELADA` retorna `CANCELADA`.
	- Se `data`, `horario_inicio` ou `horario_termino` estiverem vazios, mantém status atual (ou `AGENDADA` por padrão).
	- Converte `data + horario_inicio/termino` para objetos Carbon e compara com `now()`:
		- >= `termino` => `REALIZADA`
		- >= `inicio` => `EM_ANDAMENTO`
		- caso contrário => `AGENDADA`

## Rotas relevantes

- `/dashboard` (GET) — exibe painel (consulta por `data` querystring). Implementação em [routes/web.php](routes/web.php).
- Recursos RESTful:
	- `/cursos` — controller `CursoController`
	- `/professores` — controller `ProfessorController`
	- `/salas` — controller `SalaController`
	- `/aulas` — controller `AulaController`

Filtros por querystring (implementação de filtros disponíveis no controller de Aulas): `data_de`, `data_ate`, `horario_de`, `horario_ate`, `salas[]`, `cursos[]`, `professores[]`, `status`, `materia`.

## Views e onde o horário é exibido

- Painel (TV): `resources/views/dashboard.blade.php` — coluna `Horário` exibe `$aula->horario_formatado` (accessor do model).
- Lista de aulas (index): `resources/views/aulas/index.blade.php` também exibe `horario_formatado`.
- Formulário de Aulas: `resources/views/aulas/create.blade.php` — campos `horario_inicio` e `horario_termino` (input `type=time`).

## Formatos de dados

- `data`: `YYYY-MM-DD` (campo `date`).
- `horario_inicio` / `horario_termino`: entrada via `H:i` (ex.: `08:30`); armazenado como `H:i:s` (ex.: `08:30:00`).
- `horario` (string): representação legível `HH:MM - HH:MM` usada para exibição rápida.

## Comandos úteis e manutenção

- Limpar views compiladas (forçar recompilação Blade):

```bash
php artisan view:clear
```

- Limpar caches do framework (config, routes, views, events):

```bash
php artisan optimize:clear
```

- Rodar testes:

```bash
./vendor/bin/phpunit
```

## Como executar localmente

1. Instalar dependências

```bash
composer install
npm install
```

2. Copiar `.env` e gerar chave

```bash
cp .env.example .env
php artisan key:generate
```

3. Configurar banco (ex.: .env) e rodar migrations

```bash
php artisan migrate
```

4. Iniciar servidores em desenvolvimento

```bash
php artisan serve
npm run dev
```

## Testes automatizados

Há testes de unidade e feature cobrindo filtros, atualização automática de status e endpoints principais em `tests/Unit` e `tests/Feature`.

## Observações finais

- O painel utiliza auto-refresh via AJAX a cada minuto para atualizar o conteúdo em modo TV sem recarregar a página.
- A validação de horários impede conflitos para mesma `data` entre aulas que se sobreponham (por `professor_id` e `sala_id`).
- Se quiser, eu posso gerar um changelog separado com commits que introduziram filtros e melhorias, ou adicionar exemplos de querystring para cada filtro no README.

---
