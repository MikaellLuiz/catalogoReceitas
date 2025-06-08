# 🍳 API Catálogo de Receitas Apocalípticas

## 📚 Sobre o Projeto

Este projeto é resultado do trabalho da disciplina **Aplicações para Internet**, desenvolvido como uma API RESTful completa em PHP que implementa um sistema de gerenciamento de receitas temáticas para sobrevivência apocalíptica.

### 📋 Informações Acadêmicas

- **Disciplina:** Aplicações para Internet
- **Entrega:** 03/06/2025
- **Apresentação:** 03/06/2025
- **Valor:** 15 Pontos

### 👥 Integrantes

- **Mikael Luiz de Lima Fernandes** - 5155344
- **Emiliane Cecília Araújo Rocha** - 5156419
- **Carlos Alberto Luiz Rocha Neto** - 5156488

## 🎯 Objetivo

Desenvolver uma API RESTful completa em PHP utilizando o padrão MVC com separação em camadas (Controller, Service, DAO) e aplicação de boas práticas de desenvolvimento. O sistema gerencia receitas de sobrevivência e seus ingredientes com operações completas de CRUD, incluindo **sistema de autenticação JWT** e **tratamento robusto de erros**.

## 🔐 Funcionalidades de Segurança

### Sistema de Autenticação JWT
- **Autenticação completa** com login, registro e validação de tokens
- **Middleware de proteção** para rotas sensíveis
- **Tokens seguros** com expiração de 1 hora
- **Hash de senhas** com algoritmos seguros

### Tratamento de Erros Robusto
- **Try-catch** implementado em todas as camadas
- **Respostas JSON padronizadas** para todos os cenários
- **Códigos HTTP apropriados** (200, 401, 404, 500, etc.)
- **Timestamps** em todas as respostas de erro

> 📖 **Documentação Detalhada:** Para informações completas sobre autenticação JWT, middleware e tratamento de erros, consulte [`JWT_IMPLEMENTATION.md`](JWT_IMPLEMENTATION.md)

## 🏗️ Arquitetura

### Padrão MVC Implementado

A arquitetura segue rigorosamente o padrão **Model-View-Controller (MVC)** com separação clara de responsabilidades:

#### 🎮 **Controller** (Camada de Apresentação)
- **Responsabilidade:** Receber requisições HTTP, validar entrada e retornar respostas
- **Localização:** `/controller/`
- **Arquivos:** `Receita.php`, `Ingrediente.php`, `Auth.php` (autenticação)
- **Funcionalidades:** Endpoints REST, validação de parâmetros, formatação de respostas

#### 🔧 **Service** (Camada de Regras de Negócio)
- **Responsabilidade:** Implementar regras de negócio e validações específicas
- **Localização:** `/service/`
- **Arquivos:** `ReceitaService.php`, `IngredienteService.php`, `AuthService.php`
- **Funcionalidades:** Validação de dificuldade, regras de relacionamento, autenticação, lógica de negócio

#### 💾 **DAO** (Camada de Acesso a Dados - Model)
- **Responsabilidade:** Abstração do banco de dados e operações CRUD
- **Localização:** `/dao/` e `/dao/mysql/`
- **Arquivos:** Interfaces (`IReceitaDAO.php`, `IIngredienteDAO.php`, `IUsuarioDAO.php`) e implementações MySQL
- **Funcionalidades:** Queries SQL, mapeamento objeto-relacional, transações

#### 🌐 **Generic** (Infraestrutura)
- **Responsabilidade:** Componentes reutilizáveis e infraestrutura
- **Localização:** `/generic/`
- **Funcionalidades:** Roteamento, conexão com banco, autoloading, respostas padronizadas, **JWT Helper**, **AuthMiddleware**

## 📁 Estrutura do Projeto

```
catalogoReceitas/
├── controller/              # 🎮 Camada de apresentação
│   ├── Auth.php            # 🔐 Controller de autenticação (JWT)
│   ├── Receita.php         # Controlador de receitas
│   └── Ingrediente.php     # Controlador de ingredientes
├── service/                # 🔧 Camada de regras de negócio
│   ├── AuthService.php     # 🔐 Serviço de autenticação
│   ├── ReceitaService.php  # Lógica de negócio das receitas
│   └── IngredienteService.php # Lógica de negócio dos ingredientes
├── dao/                    # 💾 Camada de acesso a dados
│   ├── IReceitaDAO.php     # Interface para Receita DAO
│   ├── IIngredienteDAO.php # Interface para Ingrediente DAO
│   ├── IUsuarioDAO.php     # 🔐 Interface para Usuario DAO
│   └── mysql/              # Implementações MySQL
│       ├── ReceitaDAO.php  # Acesso aos dados de receitas
│       ├── IngredienteDAO.php # Acesso aos dados de ingredientes
│       └── UsuarioDAO.php  # 🔐 Acesso aos dados de usuários
├── generic/                # 🌐 Infraestrutura e utilitários
│   ├── Acao.php           # Processamento de endpoints
│   ├── Autoload.php       # Carregamento automático de classes
│   ├── AuthMiddleware.php # 🔐 Middleware de autenticação JWT
│   ├── Controller.php     # Controlador base
│   ├── Endpoint.php       # Mapeamento de endpoints
│   ├── JwtHelper.php      # 🔐 Helper para operações JWT
│   ├── MysqlFactory.php   # Factory para MySQL
│   ├── MysqlSingleton.php # Singleton para conexão MySQL
│   ├── Retorno.php        # Padronização de respostas
│   └── Rotas.php          # Gerenciamento de rotas
├── docker/                 # 🐳 Configurações Docker
│   ├── nginx.conf         # Configuração do Nginx
│   ├── mysql-config.cnf   # Configuração do MySQL
│   └── php.ini            # Configuração do PHP
├── database_setup.sql      # 🗄️ Script de criação e população do banco
├── docker-compose.yml      # 🚢 Orquestração dos containers
├── Dockerfile             # 📦 Imagem PHP customizada
├── .env                   # 🔐 Variáveis de ambiente
├── .dockerignore          # 🚫 Arquivos ignorados pelo Docker
├── .htaccess              # ⚙️ Configurações Apache/Nginx
├── index.php              # 🚪 Ponto de entrada da API
├── API_ENDPOINTS.md       # 📋 Documentação completa dos endpoints
├── JWT_IMPLEMENTATION.md  # 🔐 Documentação da implementação JWT
├── Receitas_API_Postman_Collection.json    # 📋 Coleção Postman
├── Receitas_API_Environment.postman_environment.json # 🌍 Ambiente Postman
└── README.md              # 📚 Esta documentação
```

### Tecnologias Utilizadas

- **Backend:** PHP 8.1+ com orientação a objetos
- **Autenticação:** JWT (JSON Web Tokens) com middleware personalizado
- **Segurança:** Hash de senhas, proteção de rotas, CORS configurado
- **Banco de Dados:** MySQL 8.0 with charset UTF-8 (utf8mb4_unicode_ci)
- **Servidor Web:** Nginx 1.25 com configuração FastCGI
- **Containerização:** Docker & Docker Compose
- **Arquitetura:** API RESTful com padrão MVC rigoroso
- **Codificação:** UTF-8 completo (mb_check_encoding + mb_convert_encoding)
- **Testes:** Coleção Postman completa com ambiente configurado

### Arquivos de Configuração Importantes

#### Ambiente e Deploy
- **`.env`** - Variáveis de ambiente (credenciais, configurações)
- **`docker-compose.yml`** - Orquestração completa dos serviços
- **`Dockerfile`** - Imagem PHP customizada
- **`.dockerignore`** - Otimização da build do Docker

#### Configurações de Servidor
- **`.htaccess`** - Regras de reescrita e configurações Apache/Nginx
- **`docker/nginx.conf`** - Configuração Nginx com charset UTF-8
- **`docker/php.ini`** - Configurações PHP otimizadas
- **`docker/mysql-config.cnf`** - Charset e collation MySQL

#### Ponto de Entrada e Roteamento
- **`index.php`** - Bootstrap da aplicação e roteamento principal
- **`generic/Rotas.php`** - Mapeamento de rotas para controllers
- **`generic/Acao.php`** - Processamento de endpoints com suporte UTF-8

#### Testes e Documentação
- **`API_ENDPOINTS.md`** - Documentação completa de todos os endpoints da API
- **`API_ENDPOINTS.md`** - Documentação completa de todos os endpoints da API
- **`JWT_IMPLEMENTATION.md`** - Documentação detalhada da implementação JWT e autenticação
- **`Receitas_API_Postman_Collection.json`** - Todos os endpoints testados
- **`Receitas_API_Environment.postman_environment.json`** - Ambiente com variáveis

> 📖 **Documentação Específica:** Para detalhes sobre endpoints e testes, consulte [`API_ENDPOINTS.md`](API_ENDPOINTS.md)

## 🚀 Como Executar

### Pré-requisitos
- Docker e Docker Compose instalados
- Git para clonar o repositório

### Passos para Execução

1. **Clone o repositório:**
```bash
git clone [URL_DO_REPOSITORIO]
cd catalogoReceitas
```

2. **Inicie os containers:**
```bash
docker-compose up -d
```

3. **Aguarde a inicialização** (aproximadamente 30 segundos)

4. **Acesse a API:**
- **API Base:** http://localhost:8080
- **PHPMyAdmin:** http://localhost:8081 (user: `user`, password: `password`)

## 📡 Endpoints da API

> 📋 **Documentação Completa:** Para lista detalhada de todos os endpoints, exemplos de uso e códigos de resposta, consulte [`API_ENDPOINTS.md`](API_ENDPOINTS.md)

### 🔐 Autenticação (Rotas Públicas)
| Método | Endpoint | Descrição | Autenticação |
|--------|----------|-----------|--------------|
| `POST` | `/auth/login` | Login do usuário | ❌ Não requerida |
| `POST` | `/auth/registrar` | Registro de novo usuário | ❌ Não requerida |
| `POST` | `/auth/validarToken` | Validação de token JWT | ❌ Não requerida |

### 🍳 Receitas (Rotas Protegidas)
| Método | Endpoint | Descrição | Autenticação |
|--------|----------|-----------|--------------|
| `GET` | `/receita/listar` | Lista todas as receitas | 🔐 Bearer Token |
| `GET` | `/receita/buscar/{id}` | Busca receita específica | 🔐 Bearer Token |
| `POST` | `/receita/inserir` | Cria nova receita | 🔐 Bearer Token |
| `PUT` | `/receita/atualizar/{id}` | Atualiza receita | 🔐 Bearer Token |
| `DELETE` | `/receita/deletar/{id}` | Remove receita | 🔐 Bearer Token |

### 🥕 Ingredientes (Rotas Protegidas)
| Método | Endpoint | Descrição | Autenticação |
|--------|----------|-----------|--------------|
| `GET` | `/ingrediente/listar` | Lista todos os ingredientes | 🔐 Bearer Token |
| `GET` | `/ingrediente/buscar/{id}` | Busca ingrediente específico | 🔐 Bearer Token |
| `POST` | `/ingrediente/inserir` | Cria novo ingrediente | 🔐 Bearer Token |
| `PUT` | `/ingrediente/atualizar/{id}` | Atualiza ingrediente | 🔐 Bearer Token |
| `DELETE` | `/ingrediente/deletar/{id}` | Remove ingrediente | 🔐 Bearer Token |

### 🥕 Ingredientes

| Método | Endpoint | Descrição | Body (JSON) |
|--------|----------|-----------|-------------|
| `GET` | `/ingrediente` | Lista todos os ingredientes | - |
| `GET` | `/ingrediente/{id}` | Busca ingrediente específico | - |
| `POST` | `/ingrediente` | Cria novo ingrediente | `{"nome": "string"}` |
| `PUT` | `/ingrediente/{id}` | Atualiza ingrediente | `{"nome": "string"}` |
| `DELETE` | `/ingrediente/{id}` | Remove ingrediente | - |

### 🔗 Relacionamentos Receita-Ingrediente

| Método | Endpoint | Descrição | Body (JSON) |
|--------|----------|-----------|-------------|
| `GET` | `/receita/{id}/ingredientes` | Lista ingredientes de uma receita | - |
| `POST` | `/receita/{id}/ingredientes` | Adiciona ingrediente à receita | `{"ingrediente_id": int}` |
| `DELETE` | `/receita/{id}/ingredientes/{ingrediente_id}` | Remove ingrediente da receita | - |

## 📝 Exemplos de Uso

### Autenticação
```bash
# Login para obter token
curl -X POST http://localhost:8080/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@teste.com",
    "senha": "123456"
  }'
```

### Criar uma Nova Receita (com autenticação)
```bash
curl -X POST http://localhost:8080/receita/inserir \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {SEU_TOKEN_JWT}" \
  -d '{
    "nome": "Macarrão de Sobrevivência",
    "descricao": "Um macarrão nutritivo para situações extremas",
    "modo_preparo": "Cozinhe em água fervente por 10 minutos",
    "tempo_preparo": 20,
    "porcoes": 4
  }'
```

### Listar Todas as Receitas (com autenticação)
```bash
curl http://localhost:8080/receita/listar \
  -H "Authorization: Bearer {SEU_TOKEN_JWT}"
```

### Usuários de Teste Disponíveis
- **Email:** admin@teste.com | **Senha:** 123456
- **Email:** usuario@teste.com | **Senha:** 123456

## 🗄️ Banco de Dados

### Estrutura das Tabelas

#### Tabela `usuarios` 🔐
- `id` (INT, PK, AUTO_INCREMENT)
- `email` (VARCHAR(255), NOT NULL, UNIQUE)
- `senha` (VARCHAR(255), NOT NULL) - Hash da senha
- `nome` (VARCHAR(255), NOT NULL)
- `ativo` (BOOLEAN, DEFAULT TRUE)
- `created_at`, `updated_at` (TIMESTAMP)

#### Tabela `receitas`
- `id` (INT, PK, AUTO_INCREMENT)
- `titulo` (VARCHAR(100), NOT NULL)
- `descricao` (TEXT)
- `dificuldade` (ENUM: 'Fácil', 'Média', 'Difícil')
- `tempo_preparo` (INT, NOT NULL) - em minutos
- `created_at`, `updated_at` (TIMESTAMP)

#### Tabela `ingredientes`
- `id` (INT, PK, AUTO_INCREMENT)
- `nome` (VARCHAR(100), NOT NULL, UNIQUE)
- `created_at`, `updated_at` (TIMESTAMP)

#### Tabela `receita_ingrediente`
- `receita_id` (INT, FK)
- `ingrediente_id` (INT, FK)
- `quantidade` (VARCHAR(50))
- `created_at` (TIMESTAMP)

### Dados de Exemplo

O sistema vem com **receitas temáticas** e **usuários de teste** pré-cadastrados:

#### 🔐 Usuários de Teste
- **Administrador** - Email: `admin@teste.com` | Senha: `123456`
- **Usuário Comum** - Email: `usuario@teste.com` | Senha: `123456`

#### 🍳 Receitas Apocalípticas
- **Sopa do Fim do Mundo** - Nutritiva para sobreviventes
- **Ensopado de Sobrevivência** - Robusto com ingredientes duráveis
- **Pão de Guerra** - Denso e de longa duração
- **Pasta Energética** - Recuperação rápida de energia
- **Feijão Trepeiro** - Receita especial com ingredientes "provocantes"
- **Salsicha Maliciosa** - Explosão de sabores
- **Ovo Provocante** - Experiência sensorial única
- **Banana Safada** - Sobremesa irresistível
- **Linguiça Pervertida** - Temperos intensos

## ✨ Características Técnicas

### 🔐 Segurança e Autenticação
- **JWT Token:** Algoritmo HS256 com expiração de 1 hora
- **Hash de Senhas:** `password_hash()` com salt automático
- **Middleware:** Verificação automática em rotas protegidas
- **CORS:** Headers configurados para requisições cross-origin
- **Validação de Token:** Verificação de assinatura e expiração

### 📋 Validações Implementadas
- **Email:** Validação de formato e unicidade
- **Senhas:** Validação de força e hash seguro
- **Tokens JWT:** Verificação de estrutura, assinatura e expiração
- **Dificuldade:** Enum restrito ("Fácil", "Média", "Difícil") com validação no Service
- **Tempo de Preparo:** Validação de número positivo
- **Nomes/Títulos:** Validação de strings não vazias
- **Relacionamentos:** Verificação de existência das entidades antes de criar vínculos
- **IDs:** Validação de inteiros positivos para parâmetros de rota

### 🚨 Tratamento de Erros
- **Try-Catch:** Implementado em todas as camadas (DAO/Service/Controller)
- **Respostas Padronizadas:** JSON com formato consistente
- **Códigos HTTP:** Status apropriados (200, 401, 404, 500, etc.)
- **Timestamps:** Em todas as respostas de erro

### Solução Completa UTF-8
O projeto implementa uma **solução robusta** para problemas de codificação UTF-8:

#### No Banco de Dados (MySQL)
- **Charset:** `utf8mb4` com collation `utf8mb4_unicode_ci`
- **Configuração:** `docker/mysql-config.cnf` força UTF-8 em todas as conexões
- **Tabelas:** Criadas com charset explícito UTF-8

#### No Servidor Web (Nginx)
- **Header:** `charset utf-8;` em todas as respostas
- **FastCGI:** Configuração específica para preservar encoding
- **Content-Type:** `application/json; charset=utf-8`

#### No PHP (Application Layer)
- **Correção Automática:** `mb_check_encoding()` e `mb_convert_encoding()`
- **Headers Forçados:** `header('Content-Type: application/json; charset=utf-8')`
- **Input Processing:** Tratamento especial do `php://input` para UTF-8

#### Método `obterDadosRequisicao()` nos Controllers
```php
private function obterDadosRequisicao() {
    $input = file_get_contents('php://input');
    if (!mb_check_encoding($input, 'UTF-8')) {
        $input = mb_convert_encoding($input, 'UTF-8', 'auto');
    }
    return json_decode($input, true);
}
```

### Tratamento de Endpoints
- **Roteamento Dinâmico:** Sistema flexível de rotas com parâmetros
- **Método HTTP:** Verificação rigorosa dos verbos permitidos
- **Parâmetros de Rota:** Extração automática de IDs e validação
- **Corpo da Requisição:** Processamento inteligente do JSON com correção UTF-8

### Padrões de Resposta da API
Todas as respostas seguem o formato padronizado:
```json
{
  "erro": null | {"codigo": int, "mensagem": "string", "timestamp": "ISO_DATE"},
  "dados": [...] | "mensagem de sucesso" | objeto
}
```

### Códigos de Status HTTP Apropriados
- **200 OK** - Operação realizada com sucesso
- **201 Created** - Recurso criado com sucesso (registro, criação)
- **400 Bad Request** - Erro de validação ou dados inválidos
- **401 Unauthorized** - Token JWT inválido, expirado ou ausente
- **404 Not Found** - Recurso não encontrado (receita/ingrediente/usuário inexistente)
- **409 Conflict** - Conflito de dados (email já cadastrado)
- **500 Internal Server Error** - Erro interno do servidor ou banco de dados

## 🛠️ Boas Práticas Implementadas

### Arquitetura
- ✅ Separação clara de responsabilidades (MVC)
- ✅ Padrão Singleton para conexão com banco
- ✅ Injeção de dependências
- ✅ Abstração com interfaces (DAO)
- ✅ **Middleware de autenticação** para proteção de rotas
- ✅ **Factory Pattern** para DAOs com configuração flexível

### Segurança
- ✅ **Autenticação JWT** com tokens seguros
- ✅ **Hash de senhas** com algoritmos robustos
- ✅ **Proteção de rotas** sensíveis
- ✅ **Validação de entrada** em todas as camadas
- ✅ **Headers CORS** configurados adequadamente

### Código
- ✅ Nomenclatura clara e consistente
- ✅ Documentação inline completa
- ✅ **Tratamento robusto de erros** com try-catch
- ✅ **Validação de dados** em múltiplas camadas
- ✅ **Logs estruturados** com timestamps

### API REST
- ✅ URLs semânticas e padronizadas
- ✅ Verbos HTTP apropriados
- ✅ Headers corretos (incluindo Authorization)
- ✅ Códigos de status apropriados
- ✅ **Formato JSON consistente** em todas as respostas
- ✅ Formato JSON consistente

## 📚 Documentação Adicional

### Coleção Postman
O projeto inclui uma coleção completa do Postman com todos os endpoints testados:
- `Receitas_API_Postman_Collection.json` - Todos os endpoints incluindo autenticação
- `Receitas_API_Environment.postman_environment.json` - Variáveis de ambiente

### Documentação Específica
- [`API_ENDPOINTS.md`](API_ENDPOINTS.md) - Lista completa de endpoints com exemplos
- [`API_ENDPOINTS.md`](API_ENDPOINTS.md) - Lista completa de endpoints com exemplos
- [`JWT_IMPLEMENTATION.md`](JWT_IMPLEMENTATION.md) - Detalhes da implementação de autenticação

### Estrutura de Resposta Padrão
Todas as respostas seguem o formato:
```json
{
  "erro": null | {"codigo": int, "mensagem": "string", "timestamp": "ISO_DATE"},
  "dados": [...] | "mensagem de sucesso" | objeto
}
```

## 🎯 Objetivos Alcançados

### ✅ **Arquitetura e Padrões**
- **API RESTful completa** com todos os verbos HTTP (GET, POST, PUT, DELETE)
- **Padrão MVC rigoroso** com separação clara Controller → Service → DAO
- **Interfaces e abstrações** (IReceitaDAO, IIngredienteDAO, IUsuarioDAO) para flexibilidade
- **Singleton pattern** para conexão com banco de dados
- **Factory pattern** para criação de objetos DAO
- **Middleware pattern** para autenticação automática

### ✅ **Sistema de Autenticação JWT**
- **JWT completo** com login, registro e validação de tokens
- **Middleware de proteção** automático para rotas sensíveis
- **Hash seguro de senhas** com algoritmos robustos
- **Expiração de tokens** configurável (1 hora padrão)
- **Rotas públicas e protegidas** claramente definidas

### ✅ **Banco de Dados e Persistência**
- **MySQL normalizado** com relacionamentos N:N (receita_ingrediente)
- **Charset UTF-8 completo** (utf8mb4_unicode_ci) em toda a stack
- **Transações** e controle de integridade referencial
- **Dados de exemplo** com receitas temáticas pré-cadastradas

### ✅ **Funcionalidades Implementadas**
- **CRUD completo** para receitas, ingredientes e usuários
- **Sistema de autenticação** com login, registro e validação
- **Relacionamentos** receita-ingrediente com operações específicas
- **Validações robustas** (email, senha, dificuldade, tempo, existência de entidades)
- **Proteção de rotas** com middleware automático
- **Tratamento de erros** robusto com códigos HTTP apropriados

### ✅ **Segurança e Qualidade**
- **Autenticação JWT** com tokens seguros e expiração
- **Hash de senhas** com algoritmos robustos (bcrypt)
- **Try-catch** implementado em todas as camadas
- **Respostas JSON padronizadas** para todos os cenários
- **Codificação UTF-8** com correção automática de problemas de encoding
- **Headers CORS** configurados para segurança

### ✅ **Infraestrutura e Deploy**
- **Docker multi-container** (PHP-FPM, Nginx, MySQL, PHPMyAdmin)
- **Configurações de produção** com .env, .dockerignore, .htaccess
- **Roteamento dinâmico** com sistema flexível de URLs e proteção
- **Autoloading** de classes para organização do código
- **Banco de dados** normalizado com charset UTF-8 completo

### ✅ **Testes e Documentação**
- **Collection Postman completa** com todos os endpoints incluindo autenticação
- **Documentação detalhada** dividida por tema (API, JWT, Postman)
- **Usuários de teste** pré-cadastrados para validação
- **Cenários de teste** abrangentes (sucesso, erro, autenticação)
- **Ambiente configurado** com variáveis para diferentes ambientes
- **Exemplos de uso** documentados para cada endpoint
- **Validação de funcionamento** CRUD completo testado

### ✅ **Recursos Técnicos Avançados**
- **Sistema de autenticação JWT** completo e seguro
- **Middleware automático** para proteção de rotas
- **Tratamento robusto de erros** com try-catch em todas as camadas
- **Correção automática UTF-8** com `mb_check_encoding()` e `mb_convert_encoding()`
- **Headers apropriados** para APIs REST (Content-Type, Authorization, charset)
- **Processamento JSON robusto** com tratamento de `php://input`
- **Sistema de rotas RESTful** com parâmetros dinâmicos e proteção

### 🎓 **Valor Acadêmico**
- Demonstra domínio completo do **padrão MVC** com camadas bem definidas
- Implementa **autenticação moderna** com JWT e middleware
- Aplica **tratamento de erros** profissional em todas as camadas
- Utiliza **tecnologias modernas** (Docker, REST APIs, JWT, UTF-8)
- Apresenta **documentação profissional** dividida por contexto
- Segue **boas práticas de segurança** para APIs em produção

## 🔧 Desenvolvimento e Testes

### Comandos Úteis para Desenvolvimento

#### Gerenciamento dos Containers
```bash
# Iniciar todos os serviços
docker-compose up -d

# Parar todos os serviços
docker-compose down

# Rebuild completo (após mudanças no Dockerfile)
docker-compose down && docker-compose build --no-cache && docker-compose up -d

# Ver logs em tempo real
docker-compose logs -f

# Ver logs de um serviço específico
docker-compose logs -f php
docker-compose logs -f nginx
docker-compose logs -f mysql
```

#### Acesso aos Containers
```bash
# Acessar container PHP para debug
docker exec -it receitas_apocalipticas_php bash

# Acessar MySQL via linha de comando
docker exec -it receitas_apocalipticas_db mysql -u receitas_user -preceitas123 receitas_apocalipticas

# Verificar processos rodando
docker-compose ps
```

#### Testes Rápidos da API
```bash
# Teste básico - endpoint raiz
curl http://localhost:8080/

# Listar todas as receitas
curl http://localhost:8080/receita

# Buscar receita específica
curl http://localhost:8080/receita/1

# Criar nova receita (teste UTF-8)
curl -X POST http://localhost:8080/receita \
  -H "Content-Type: application/json" \
  -d '{"titulo":"Açaí Brasileiro","descricao":"Receita com acentos português","dificuldade":"Fácil","tempo_preparo":15}'
```

### Solução de Problemas

#### Problemas de Codificação UTF-8
Se ainda encontrar problemas com acentos:
1. Verificar se o banco está com charset correto:
```sql
SHOW CREATE TABLE receitas;
```
2. Confirmar headers HTTP:
```bash
curl -I http://localhost:8080/receita
```

#### Reset Completo do Ambiente
```bash
# Para completo do ambiente e limpeza
docker-compose down -v
docker system prune -f
docker-compose up -d
```

#### Verificação de Saúde dos Serviços
```bash
# Verificar se todos os serviços estão rodando
docker-compose ps

# Testar conectividade com banco
docker exec receitas_apocalipticas_php php -r "try { new PDO('mysql:host=mysql;dbname=receitas_apocalipticas', 'receitas_user', 'receitas123'); echo 'Conexão OK\n'; } catch(Exception \$e) { echo 'Erro: ' . \$e->getMessage() . '\n'; }"
```

### Acessos Disponíveis

- **🌐 API Principal:** http://localhost:8080
- **📊 PHPMyAdmin:** http://localhost:8081
  - **Usuário:** `receitas_user`
  - **Senha:** `receitas123`
  - **Banco:** `receitas_apocalipticas`
- **📁 Logs:** `docker-compose logs [serviço]`

### Estrutura dos Dados de Teste

O banco vem populado com dados que demonstram:
- ✅ **Sistema de usuários** com autenticação funcional
- ✅ **Tokens JWT** válidos para testes imediatos
- ✅ **Receitas temáticas** com suporte completo UTF-8
- ✅ **Validação de dificuldade** (Fácil, Média, Difícil)
- ✅ **Relacionamentos N:N** (receitas com múltiplos ingredientes)
- ✅ **Tratamento de erros** em todos os cenários

### Testes Recomendados
1. **Autenticação:** Login → Obter token → Usar em requisições protegidas
2. **CRUD Protegido:** Testar todas as operações com e sem autenticação
3. **Validação de Erros:** Testar cenários de erro (token inválido, dados malformados)
4. **Cenários UTF-8:** Verificar caracteres especiais nas receitas

---

## 🚀 Conclusão

Este projeto representa uma **implementação completa e profissional** de uma API RESTful moderna, incorporando:

### 🔥 **Diferenciais Implementados**
- **🔐 Autenticação JWT completa** com middleware automático
- **🛡️ Segurança robusta** com hash de senhas e proteção de rotas
- **⚡ Tratamento de erros** em todas as camadas com try-catch
- **📋 Respostas padronizadas** JSON para todos os cenários
- **🌐 Suporte UTF-8 completo** em toda a stack
- **📚 Documentação detalhada** separada por contexto

### 🎯 **Resultado Final**
Uma API de produção pronta para uso real, que vai além dos requisitos básicos de CRUD, implementando padrões modernos de segurança e melhores práticas de desenvolvimento web.

---

## 📞 Contato

Para dúvidas sobre o projeto, entre em contato com qualquer um dos integrantes listados acima.

---

*Projeto desenvolvido como trabalho acadêmico para a disciplina de Aplicações para Internet.*
