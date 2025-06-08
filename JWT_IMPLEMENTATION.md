# 🔐 Implementação de Autenticação JWT

## 📋 Sobre Esta Implementação

Este documento detalha a implementação completa do sistema de autenticação JWT que foi adicionado à API de Receitas Apocalípticas, incluindo middleware de autenticação, tratamento de erros robusto e proteção de rotas.

## 🚀 Funcionalidades Implementadas

### ✅ Sistema de Autenticação JWT
- **Algoritmo:** HS256 (HMAC SHA-256)
- **Expiração:** 1 hora (3600 segundos)
- **Chave Secreta:** Configurável via ambiente
- **Headers:** `Authorization: Bearer {token}`

### ✅ Middleware de Autenticação
- Verificação automática de tokens em rotas protegidas
- Validação de formato Bearer token
- Decodificação e validação de payload JWT
- Tratamento de tokens expirados e inválidos

### ✅ Tratamento de Erros Robusto
- Try-catch implementado em todas as camadas (DAO/Service/Controller)
- Respostas JSON padronizadas para todos os cenários
- Códigos de status HTTP apropriados
- Timestamps em todas as respostas de erro

### ✅ Proteção de Rotas
- **Rotas Públicas:** `/auth/*` (login, registro, validação)
- **Rotas Protegidas:** `/receita/*` e `/ingrediente/*`
- Configuração flexível por endpoint

## 🏗️ Arquitetura de Segurança

### Camadas de Autenticação

```
┌─────────────────┐
│   Cliente       │ ──── Authorization: Bearer {token}
└─────────────────┘
          │
┌─────────────────┐
│  AuthMiddleware │ ──── Validação do Token JWT
└─────────────────┘
          │
┌─────────────────┐
│   Controller    │ ──── Processamento da Requisição
└─────────────────┘
          │
┌─────────────────┐
│    Service      │ ──── Lógica de Negócio
└─────────────────┘
          │
┌─────────────────┐
│      DAO        │ ──── Acesso aos Dados
└─────────────────┘
```

## 📁 Arquivos Criados/Modificados

### 🆕 Novos Arquivos

#### Autenticação
- `/generic/JwtHelper.php` - Classe helper para operações JWT
- `/generic/AuthMiddleware.php` - Middleware de autenticação
- `/dao/IUsuarioDAO.php` - Interface do DAO de usuários
- `/dao/mysql/UsuarioDAO.php` - Implementação MySQL do DAO de usuários
- `/service/AuthService.php` - Serviço de autenticação completo
- `/controller/Auth.php` - Controller de endpoints de autenticação

#### Documentação
- `/API_ENDPOINTS.md` - Documentação completa dos endpoints da API
- `/JWT_IMPLEMENTATION.md` - Este arquivo (documentação da implementação JWT)

### 🔄 Arquivos Modificados

#### Base de Dados
- `/database_setup.sql` - Adicionada tabela `usuarios` com dados de teste

#### Infraestrutura
- `/generic/Rotas.php` - Configuração de rotas públicas e protegidas
- `/generic/Endpoint.php` - Adicionada flag `requerAutenticacao`
- `/generic/Acao.php` - Integração com sistema de autenticação
- `/index.php` - Headers CORS e inicialização de sessão

#### Camada de Serviços
- `/service/ReceitaService.php` - Try-catch e respostas JSON padronizadas
- `/service/IngredienteService.php` - Try-catch e respostas JSON padronizadas

#### Camada de Acesso a Dados
- `/dao/mysql/ReceitaDAO.php` - Try-catch em todos os métodos
- `/dao/mysql/IngredienteDAO.php` - Try-catch em todos os métodos

#### Controllers
- `/controller/Receita.php` - Try-catch e tratamento de erros
- `/controller/Ingrediente.php` - Try-catch e tratamento de erros

## 🔑 Sistema de Usuários

### Tabela `usuarios`
```sql
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(255) NOT NULL,
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### Usuários de Teste Pré-cadastrados
1. **Administrador**
   - Email: `admin@teste.com`
   - Senha: `123456`
   - Nome: `Administrador`

2. **Usuário Comum**
   - Email: `usuario@teste.com`
   - Senha: `123456`
   - Nome: `Usuário Comum`

## 🛡️ Segurança Implementada

### Hash de Senhas
- Algoritmo: `password_hash()` com `PASSWORD_DEFAULT`
- Verificação: `password_verify()` para validação segura
- Salt automático gerado pelo PHP

### Validação de Tokens
- Verificação de assinatura HMAC
- Validação de expiração (`exp` claim)
- Verificação de estrutura do payload
- Tratamento de tokens malformados

### Proteção CORS
- Headers configurados para requisições cross-origin
- Suporte a métodos HTTP: GET, POST, PUT, DELETE, OPTIONS
- Headers permitidos: Content-Type, Authorization

## 📡 Endpoints de Autenticação

### POST `/auth/login`
Autentica usuário e retorna token JWT.

**Request:**
```json
{
    "email": "admin@teste.com",
    "senha": "123456"
}
```

**Response (Sucesso):**
```json
{
    "erro": null,
    "dados": {
        "sucesso": true,
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "usuario": {
            "id": 1,
            "email": "admin@teste.com",
            "nome": "Administrador"
        },
        "expires_in": 3600
    }
}
```

### POST `/auth/registrar`
Registra novo usuário no sistema.

**Request:**
```json
{
    "email": "novo@teste.com",
    "senha": "123456",
    "nome": "Novo Usuário"
}
```

### POST `/auth/validarToken`
Valida se um token JWT está válido.

**Request:**
```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
}
```

## 🚨 Tratamento de Erros

### Formato Padrão de Resposta de Erro
```json
{
    "erro": {
        "codigo": 401,
        "mensagem": "Token JWT inválido ou expirado",
        "timestamp": "2024-06-07T18:30:52-03:00"
    },
    "dados": null
}
```

### Códigos de Status HTTP
- **200 OK** - Operação realizada com sucesso
- **201 Created** - Recurso criado com sucesso
- **400 Bad Request** - Dados inválidos ou malformados
- **401 Unauthorized** - Token inválido, expirado ou ausente
- **404 Not Found** - Recurso não encontrado
- **409 Conflict** - Conflito (ex: email já cadastrado)
- **500 Internal Server Error** - Erro interno do servidor

## 🧪 Cenários de Teste Validados

### ✅ Autenticação
- Login com credenciais válidas
- Login com credenciais inválidas
- Registro de novo usuário
- Registro com email duplicado
- Validação de token válido
- Validação de token inválido
- Validação de token expirado

### ✅ Proteção de Rotas
- Acesso negado sem token
- Acesso negado com token inválido
- Acesso autorizado com token válido
- Verificação de expiração de token

### ✅ CRUD Protegido
- Criação de receitas com autenticação
- Listagem de receitas com autenticação
- Atualização de receitas com autenticação
- Exclusão de receitas com autenticação
- Todas as operações de ingredientes protegidas

## 🔧 Configuração e Personalização

### Configuração da Chave JWT
A chave secreta pode ser configurada via variável de ambiente ou diretamente na classe `JwtHelper`:

```php
// Configuração padrão
private const SECRET_KEY = 'sua_chave_secreta_super_segura_aqui_2024';

// Ou via ambiente
$secretKey = $_ENV['JWT_SECRET'] ?? self::SECRET_KEY;
```

### Configuração de Expiração
O tempo de expiração pode ser ajustado na classe `JwtHelper`:

```php
private const EXPIRATION_TIME = 3600; // 1 hora em segundos
```

### Configuração de Rotas Protegidas
No arquivo `/generic/Rotas.php`, é possível configurar quais rotas requerem autenticação:

```php
// Rotas protegidas
new Endpoint('receita/listar', 'Receita', 'GET', true),
new Endpoint('receita/buscar/{id}', 'Receita', 'GET', true),

// Rotas públicas
new Endpoint('auth/login', 'Auth', 'POST', false),
new Endpoint('auth/registrar', 'Auth', 'POST', false),
```

## 📚 Referências e Padrões

### Padrões de Segurança Seguidos
- **JWT RFC 7519** - JSON Web Token standard
- **Bearer Token Authentication** - Padrão de autenticação via header
- **CORS** - Cross-Origin Resource Sharing
- **Password Hashing** - Boas práticas de hash de senhas

### Bibliotecas e Dependências
- **Firebase JWT** - Implementação JWT para PHP (simulada com classe própria)
- **PHP Built-in Functions** - `password_hash()`, `password_verify()`
- **JSON Functions** - `json_encode()`, `json_decode()` com validação

## 🚀 Próximos Passos

### Melhorias Possíveis
- Implementação de refresh tokens
- Rate limiting para endpoints de autenticação
- Auditoria de login (logs de acesso)
- Níveis de permissão (admin, user, etc.)
- Two-factor authentication (2FA)
- Blacklist de tokens revogados

### Monitoramento
- Logs de tentativas de login
- Alertas de tokens expirados
- Métricas de uso da API
- Monitoramento de segurança

---

**Nota:** Esta implementação segue as melhores práticas de segurança para APIs RESTful e fornece uma base sólida para sistemas de autenticação em produção.
