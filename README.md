# API RESTful com Laravel - Api School

## :pushpin: Visão Geral
Esta API foi desenvolvida como projeto de estudos utilizando o framework Laravel, com o objetivo principal de aplicar e consolidar conceitos fundamentais de APIs RESTful seguindo as melhores práticas do mercado.

## :dart: Objetivos

1. Aplicação de Conceitos RESTful
- Recursos bem definidos com URLs semânticas
- Métodos Http apropriados
- Stateless
- Códigos de status HTTP adequados

## :wrench: Tecnologias e Recursos Utilizados
## Stack Principal
- Laravel
- MySQL
- Eloquent ORM
- Docker

## Recursos do Laravel Aplicados
- Migrations
- Seeders e Factories
- Eloquent Relationships
- Sanctum
- Validation Rules
- API Resources

## :bar_chart: Rotas da API
```
POST   /api/signin           - Faz login e retorna um token
```

```
GET    /api/teachers           - Lista todos os professores
POST   /api/teachers           - Cria registro de novo professor
GET    /api/teachers/{id}      - Mostra professor específico
PATCH  /api/teachers/{id}      - Atualiza dados do professor
DELETE /api/teachers/{id}      - Remove dados de professor do sistema
```

```
GET    /api/student           - Lista todos os alunos
POST   /api/student           - Cria registro de novo aluno
GET    /api/student/{id}      - Mostra aluno específico
PATCH  /api/student/{id}      - Atualiza dados do aluno
DELETE /api/student/{id}      - Remove dados de aluno do sistema
```
## :arrow_forward: Executando o projeto
Para executar o projeto, é necessário ter o docker instalado. Com o docker na sua máquina, basta criar uma pasta vazia dentro da pasta chamada dbdata, e executar o comando:

```
docker compose up -d

```
