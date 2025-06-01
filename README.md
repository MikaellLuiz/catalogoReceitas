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

Desenvolver uma API RESTful completa em PHP utilizando o padrão MVC com separação em camadas (Controller, Service, DAO) e aplicação de boas práticas de desenvolvimento. O sistema gerencia receitas de sobrevivência e seus ingredientes com operações completas de CRUD.

## 🏗️ Arquitetura

### Padrão MVC Implementado

A arquitetura segue rigorosamente o padrão **Model-View-Controller (MVC)** com separação clara de responsabilidades:

#### 🎮 **Controller** (Camada de Apresentação)
- **Responsabilidade:** Receber requisições HTTP, validar entrada e retornar respostas
- **Localização:** `/controller/`
- **Arquivos:** `Receita.php`, `Ingrediente.php`
- **Funcionalidades:** Endpoints REST, validação de parâmetros, formatação de respostas

#### 🔧 **Service** (Camada de Regras de Negócio)
- **Responsabilidade:** Implementar regras de negócio e validações específicas
- **Localização:** `/service/`
- **Arquivos:** `ReceitaService.php`, `IngredienteService.php`, `ClienteService.php`
- **Funcionalidades:** Validação de dificuldade, regras de relacionamento, lógica de negócio

#### 💾 **DAO** (Camada de Acesso a Dados - Model)
- **Responsabilidade:** Abstração do banco de dados e operações CRUD
- **Localização:** `/dao/` e `/dao/mysql/`
- **Arquivos:** Interfaces (`IReceitaDAO.php`, `IIngredienteDAO.php`) e implementações MySQL
- **Funcionalidades:** Queries SQL, mapeamento objeto-relacional, transações

#### 🌐 **Generic** (Infraestrutura)
- **Responsabilidade:** Componentes reutilizáveis e infraestrutura
- **Localização:** `/generic/`
- **Funcionalidades:** Roteamento, conexão com banco, autoloading, respostas padronizadas

## 📁 Estrutura do Projeto

```
catalogoReceitas/
├── controller/              # 🎮 Camada de apresentação
│   ├── Receita.php         # Controlador de receitas
│   └── Ingrediente.php     # Controlador de ingredientes
├── service/                # 🔧 Camada de regras de negócio
│   ├── ReceitaService.php  # Lógica de negócio das receitas
│   ├── IngredienteService.php # Lógica de negócio dos ingredientes
│   └── ClienteService.php  # Serviço auxiliar
├── dao/                    # 💾 Camada de acesso a dados
│   ├── IReceitaDAO.php     # Interface para Receita DAO
│   ├── IIngredienteDAO.php # Interface para Ingrediente DAO
│   └── mysql/              # Implementações MySQL
│       ├── ReceitaDAO.php  # Acesso aos dados de receitas
│       └── IngredienteDAO.php # Acesso aos dados de ingredientes
├── generic/                # 🌐 Infraestrutura e utilitários
│   ├── Acao.php           # Processamento de endpoints
│   ├── Autoload.php       # Carregamento automático de classes
│   ├── Controller.php     # Controlador base
│   ├── Endpoint.php       # Mapeamento de endpoints
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
├── POSTMAN_README.md      # 📮 Documentação do Postman
├── Receitas_API_Postman_Collection.json    # 📋 Coleção Postman
├── Receitas_API_Environment.postman_environment.json # 🌍 Ambiente Postman
└── README.md              # 📚 Esta documentação
```

### Tecnologias Utilizadas

- **Backend:** PHP 8.1+ com orientação a objetos
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
- **`POSTMAN_README.md`** - Instruções específicas para uso da coleção Postman
- **`Receitas_API_Postman_Collection.json`** - Todos os endpoints testados
- **`Receitas_API_Environment.postman_environment.json`** - Ambiente com variáveis

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

### 🏠 Endpoint Base
```
GET http://localhost:8080/
```
Retorna informações gerais da API e lista de endpoints disponíveis.

### 🍳 Receitas

| Método | Endpoint | Descrição | Body (JSON) |
|--------|----------|-----------|-------------|
| `GET` | `/receita` | Lista todas as receitas | - |
| `GET` | `/receita/{id}` | Busca receita específica | - |
| `POST` | `/receita` | Cria nova receita | `{"titulo": "string", "descricao": "string", "dificuldade": "Fácil\|Média\|Difícil", "tempo_preparo": int}` |
| `PUT` | `/receita/{id}` | Atualiza receita | `{"titulo": "string", "descricao": "string", "dificuldade": "Fácil\|Média\|Difícil", "tempo_preparo": int}` |
| `DELETE` | `/receita/{id}` | Remove receita | - |

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

### Criar uma Nova Receita
```bash
curl -X POST http://localhost:8080/receita \
  -H "Content-Type: application/json" \
  -d '{
    "titulo": "Macarrão de Sobrevivência",
    "descricao": "Um macarrão nutritivo para situações extremas",
    "dificuldade": "Média",
    "tempo_preparo": 20
  }'
```

### Listar Todas as Receitas
```bash
curl http://localhost:8080/receita
```

### Adicionar Ingrediente à Receita
```bash
curl -X POST http://localhost:8080/receita/1/ingredientes \
  -H "Content-Type: application/json" \
  -d '{"ingrediente_id": 3}'
```

## 🗄️ Banco de Dados

### Estrutura das Tabelas

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

O sistema vem com receitas temáticas pré-cadastradas:

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

### Validações Implementadas
- **Dificuldade:** Enum restrito ("Fácil", "Média", "Difícil") com validação no Service
- **Tempo de Preparo:** Validação de número positivo
- **Nomes/Títulos:** Validação de strings não vazias
- **Relacionamentos:** Verificação de existência das entidades antes de criar vínculos
- **IDs:** Validação de inteiros positivos para parâmetros de rota

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
  "erro": null | "mensagem de erro específica",
  "dados": [...] | "mensagem de sucesso" | objeto
}
```

### Códigos de Status HTTP Apropriados
- **200 OK** - Operação realizada com sucesso
- **404 Not Found** - Recurso não encontrado (receita/ingrediente inexistente)
- **400 Bad Request** - Erro de validação ou dados inválidos
- **500 Internal Server Error** - Erro interno do servidor ou banco de dados

## 🛠️ Boas Práticas Implementadas

### Arquitetura
- ✅ Separação clara de responsabilidades (MVC)
- ✅ Padrão Singleton para conexão com banco
- ✅ Injeção de dependências
- ✅ Abstração com interfaces (DAO)

### Código
- ✅ Nomenclatura clara e consistente
- ✅ Documentação inline
- ✅ Tratamento de erros
- ✅ Validação de dados

### API REST
- ✅ URLs semânticas e padronizadas
- ✅ Verbos HTTP apropriados
- ✅ Headers corretos
- ✅ Códigos de status apropriados
- ✅ Formato JSON consistente

## 📚 Documentação Adicional

### Coleção Postman
O projeto inclui uma coleção completa do Postman com todos os endpoints testados:
- `Receitas_API_Postman_Collection.json`
- `Receitas_API_Environment.postman_environment.json`

### Estrutura de Resposta Padrão
Todas as respostas seguem o formato:
```json
{
  "erro": null | "mensagem de erro",
  "dados": [...] | "mensagem de sucesso"
}
```

## 🎯 Objetivos Alcançados

### ✅ **Arquitetura e Padrões**
- **API RESTful completa** com todos os verbos HTTP (GET, POST, PUT, DELETE)
- **Padrão MVC rigoroso** com separação clara Controller → Service → DAO
- **Interfaces e abstrações** (IReceitaDAO, IIngredienteDAO) para flexibilidade
- **Singleton pattern** para conexão com banco de dados
- **Factory pattern** para criação de objetos DAO

### ✅ **Banco de Dados e Persistência**
- **MySQL normalizado** com relacionamentos N:N (receita_ingrediente)
- **Charset UTF-8 completo** (utf8mb4_unicode_ci) em toda a stack
- **Transações** e controle de integridade referencial
- **Dados de exemplo** com receitas temáticas pré-cadastradas

### ✅ **Funcionalidades Implementadas**
- **CRUD completo** para receitas e ingredientes
- **Relacionamentos** receita-ingrediente com operações específicas
- **Validações robustas** (dificuldade, tempo, existência de entidades)
- **Tratamento de erros** apropriado com códigos HTTP corretos

### ✅ **Qualidade e Boas Práticas**
- **Codificação UTF-8** com correção automática de problemas de encoding
- **Documentação completa** com README, Postman collection e exemplos
- **Containerização** com Docker Compose para fácil setup
- **Configurações otimizadas** para Nginx, PHP e MySQL

### ✅ **Infraestrutura e Deploy**
- **Docker multi-container** (PHP-FPM, Nginx, MySQL, PHPMyAdmin)
- **Configurações de produção** com .env, .dockerignore, .htaccess
- **Roteamento dinâmico** com sistema flexível de URLs
- **Autoloading** de classes para organização do código

### ✅ **Testes e Validação**
- **Collection Postman completa** com todos os endpoints testados
- **Ambiente configurado** com variáveis para diferentes ambientes
- **Exemplos de uso** documentados para cada endpoint
- **Validação de funcionamento** CRUD completo testado

### ✅ **Recursos Técnicos Avançados**
- **Correção automática UTF-8** com `mb_check_encoding()` e `mb_convert_encoding()`
- **Headers apropriados** para APIs REST (Content-Type, charset)
- **Processamento JSON robusto** com tratamento de `php://input`
- **Sistema de rotas RESTful** com parâmetros dinâmicos

### 🎓 **Valor Acadêmico**
- Demonstra domínio completo do **padrão MVC**
- Implementa **boas práticas** de desenvolvimento web
- Utiliza **tecnologias modernas** (Docker, REST APIs, UTF-8)
- Apresenta **documentação profissional** para apresentação acadêmica

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

O banco vem populado com receitas temáticas que demonstram:
- ✅ **Suporte completo UTF-8** (acentos, caracteres especiais)
- ✅ **Validação de dificuldade** (Fácil, Média, Difícil)
- ✅ **Relacionamentos N:N** (receitas com múltiplos ingredientes)
- ✅ **Dados realistas** para apresentação

---

## 📞 Contato

Para dúvidas sobre o projeto, entre em contato com qualquer um dos integrantes listados acima.

---

*Projeto desenvolvido como trabalho acadêmico para a disciplina de Aplicações para Internet.*
