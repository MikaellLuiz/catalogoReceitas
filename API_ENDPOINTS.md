# 📋 API Endpoints & Testing Guide - Catálogo de Receitas Apocalípticas

Esta documentação contém todos os endpoints da API e instruções completas para testes, incluindo configuração do Postman.

> 🚀 **NOVIDADE**: A collection agora possui **testes automatizados completos**! Basta clicar em "Run Collection" no Postman para executar todos os endpoints automaticamente com validações de status, captura de tokens e variáveis de ambiente.

## 📥 Como Importar e Testar no Postman

### 1. **Importar a Collection**
1. Abra o Postman
2. Clique em **Import** (botão no canto superior esquerdo)
3. Selecione o arquivo: `Receitas_API_Postman_Collection.json`
4. Clique em **Import**

### 2. **Importar o Environment** (Opcional)
1. No Postman, clique no ícone de **Environment** (engrenagem no canto superior direito)
2. Clique em **Import**
3. Selecione o arquivo: `Receitas_API_Environment.postman_environment.json`
4. Ative o environment "Receitas Apocalípticas - Local"

### 3. **Antes de começar:**
1. Certifique-se de que o Docker está rodando: `docker-compose up -d`
2. Verifique se a API está disponível em: `http://localhost:8080`

## 🎯 Execução Automatizada de Testes

### ⚡ **MODO AUTOMÁTICO (Recomendado)**
1. Clique em **"Run Collection"** no Postman
2. Deixe todos os endpoints selecionados
3. Clique em **"Run API Receitas Apocalípticas - Completa"**
4. Aguarde a execução automática de todos os testes

**O que acontece automaticamente:**
- ✅ Login e captura de token JWT
- ✅ Execução de todos os endpoints principais
- ✅ Criação e atualização de dados de teste
- ✅ Testes de validação e cenários de erro
- ✅ Limpeza opcional dos dados criados
- ✅ Relatório completo de resultados

### 🔧 **MODO MANUAL (Sequência Recomendada)**
1. **🔐 Autenticação**: Execute login para obter token JWT
2. **📋 Verificar API**: Execute "Informações da API" para confirmar funcionamento
3. **👀 Explorar dados**: Execute "Listar receitas" e "Listar ingredientes"
4. **➕ Criar dados**: Use endpoints POST para criar novos ingredientes e receitas
5. **🔗 Relacionar**: Use endpoints de relacionamento para vincular ingredientes às receitas
6. **✏️ Atualizar**: Teste endpoints PUT para modificar dados
7. **🗑️ Excluir**: Teste endpoints DELETE (cuidado com dados importantes!)

## 🔐 Autenticação (Rotas Públicas)

### POST `/auth/login`
**Descrição:** Autenticação de usuário  
**Headers:** `Content-Type: application/json`  
**Body:**
```json
{
    "email": "admin@teste.com",
    "senha": "123456"
}
```
**Resposta de Sucesso:**
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
**Descrição:** Registro de novo usuário  
**Headers:** `Content-Type: application/json`  
**Body:**
```json
{
    "email": "novo@teste.com",
    "senha": "123456",
    "nome": "Novo Usuário"
}
```

### POST `/auth/validarToken`
**Descrição:** Validação de token JWT  
**Headers:** `Content-Type: application/json`  
**Body:**
```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
}
```

## 📚 Estrutura da Collection Postman

A collection está organizada em **7 pastas principais** com testes automatizados:

### 📋 **INFORMAÇÕES DA API**
- `GET /` - Retorna informações sobre todos os endpoints
- **Testes automatizados:** Valida status 200 e estrutura da resposta

### 🔐 **AUTENTICAÇÃO**
- `POST /auth/login` - Login do usuário (captura token automaticamente)
- `POST /auth/registrar` - Registro de novo usuário  
- `POST /auth/validarToken` - Validação de token JWT
- **Testes automatizados:** Captura e armazena tokens JWT em variáveis de ambiente

### 🍽️ **RECEITAS** (Protegidas)
- `GET /receita/listar` - Listar todas as receitas (captura IDs automaticamente)
- `GET /receita/buscar/{id}` - Obter receita específica
- `POST /receita/inserir` - Criar nova receita (armazena ID da nova receita)
- `PUT /receita/atualizar/{id}` - Atualizar receita
- **Testes automatizados:** Valida estruturas JSON, status codes e captura IDs

### 🥕 **INGREDIENTES** (Protegidas)
- `GET /ingrediente/listar` - Listar todos os ingredientes (captura IDs automaticamente)
- `GET /ingrediente/buscar/{id}` - Obter ingrediente específico
- `POST /ingrediente/inserir` - Criar novo ingrediente (armazena ID do novo ingrediente)
- `PUT /ingrediente/atualizar/{id}` - Atualizar ingrediente
- **Testes automatizados:** Valida estruturas JSON, status codes e captura IDs

### 🔗 **RELACIONAMENTOS** (Protegidas)
- `GET /receita/{id}/ingredientes` - Listar ingredientes de uma receita
- `POST /receita/{id}/ingredientes` - Adicionar ingrediente à receita
- **Testes automatizados:** Valida relacionamentos e estruturas de dados

### 🧪 **TESTES DE VALIDAÇÃO** 
Endpoints para testar cenários de erro com validações automáticas:
- **Login inválido** - Testa credenciais incorretas (espera status 400)
- **Acesso sem token** - Testa segurança da API (espera status 401)  
- **Receita inexistente** - Testa ID inválido (espera status 404)
- **Dados inválidos** - Testa validação de entrada (espera status 400)
- **Email duplicado** - Testa duplicação no registro (espera status 409)

### 🗑️ **LIMPEZA (Opcional)**
- `DELETE /receita/deletar/{id}` - Excluir receita criada nos testes
- `DELETE /ingrediente/deletar/{id}` - Excluir ingrediente criado nos testes
- **Testes automatizados:** Confirma exclusão bem-sucedida

## 🔄 **VARIÁVEIS DE AMBIENTE AUTOMÁTICAS**
A collection gerencia automaticamente as seguintes variáveis:
- `authToken` - Token JWT obtido no login
- `receitaId` - ID de receita existente (capturado na listagem)
- `ingredienteId` - ID de ingrediente existente (capturado na listagem)
- `novaReceitaId` - ID da receita criada nos testes
- `novoIngredienteId` - ID do ingrediente criado nos testes

## 🍽️ Receitas (Rotas Protegidas)
**Todas as rotas requerem:** `Authorization: Bearer {token}`

### GET `/receita/listar`
**Descrição:** Lista todas as receitas

### GET `/receita/buscar/{id}`
**Descrição:** Busca receita por ID

### POST `/receita/inserir`
**Descrição:** Insere nova receita  
**Body:**
```json
{
    "nome": "Bolo de Chocolate",
    "descricao": "Delicioso bolo de chocolate",
    "modo_preparo": "Misture todos os ingredientes...",
    "tempo_preparo": 60,
    "porcoes": 8
}
```

### PUT `/receita/atualizar/{id}`
**Descrição:** Atualiza receita existente

### DELETE `/receita/deletar/{id}`
**Descrição:** Remove receita

## 🥕 Ingredientes (Rotas Protegidas)
**Todas as rotas requerem:** `Authorization: Bearer {token}`

### GET `/ingrediente/listar`
**Descrição:** Lista todos os ingredientes

### GET `/ingrediente/buscar/{id}`
**Descrição:** Busca ingrediente por ID

### POST `/ingrediente/inserir`
**Descrição:** Insere novo ingrediente  
**Body:**
```json
{
    "nome": "Farinha de Trigo",
    "unidade_medida": "g"
}
```

### PUT `/ingrediente/atualizar/{id}`
**Descrição:** Atualiza ingrediente existente

### DELETE `/ingrediente/deletar/{id}`
**Descrição:** Remove ingrediente

## 🔗 Relacionamento Receita-Ingrediente (Rotas Protegidas)
**Todas as rotas requerem:** `Authorization: Bearer {token}`

### GET `/receita/{id}/ingredientes`
**Descrição:** Lista ingredientes de uma receita específica  
**Exemplo:** `/receita/1/ingredientes`

### POST `/receita/{id}/ingredientes`
**Descrição:** Adiciona ingrediente à receita  
**Body:**
```json
{
    "ingrediente_id": 2
}
```

### DELETE `/receita/{id}/ingredientes/{ingrediente_id}`
**Descrição:** Remove ingrediente da receita  
**Exemplo:** `/receita/1/ingredientes/2`

## 📋 Códigos de Status HTTP

- **200 OK**: Sucesso
- **201 Created**: Criado com sucesso
- **400 Bad Request**: Erro de validação/dados inválidos
- **401 Unauthorized**: Não autorizado (token inválido/ausente)
- **404 Not Found**: Recurso não encontrado
- **409 Conflict**: Conflito (email já cadastrado)
- **500 Internal Server Error**: Erro interno do servidor

## 🔑 Autenticação JWT

- **Algoritmo:** HS256
- **Expiração:** 1 hora (3600 segundos)
- **Header:** `Authorization: Bearer {token}`
- **Chave secreta:** Configurada no servidor

## 👥 Usuários de Teste

✅ **Os usuários estão pré-cadastrados no banco e prontos para uso:**

1. **Administrador**
   - Email: `admin@teste.com`
   - Senha: `123456`
   - Hash: `$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm`

2. **Usuário Comum**
   - Email: `usuario@teste.com`
   - Senha: `123456`
   - Hash: `$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm`

> 🔐 **Segurança:** As senhas são armazenadas com hash bcrypt usando `password_hash()` do PHP, e validadas com `password_verify()` no processo de login.

## 📝 Estrutura dos Dados

### **Receita:**
```json
{
    "nome": "Nome da receita",
    "descricao": "Descrição detalhada",
    "modo_preparo": "Instruções de preparo",
    "tempo_preparo": 30,
    "porcoes": 4
}
```

### **Ingrediente:**
```json
{
    "nome": "Nome do ingrediente",
    "unidade_medida": "kg"
}
```

### **Relacionamento:**
```json
{
    "ingrediente_id": 2
}
```

### **Login:**
```json
{
    "email": "admin@teste.com",
    "senha": "123456"
}
```

## 🔧 Configurações Postman

### **URL Base:**
- Local: `http://localhost:8080`
- Produção: Altere a variável `baseUrl` no environment

### **Headers Automáticos:**
Todos os endpoints POST/PUT já estão configurados com:
- `Content-Type: application/json`
- `Authorization: Bearer {token}` (para rotas protegidas)

### **Variáveis de Ambiente:**
- `baseUrl`: URL base da API
- `authToken`: Token JWT obtido no login (configurar manualmente após login)

## ⚠️ Tratamento de Erros

Todos os endpoints retornam respostas padronizadas:

**Formato de Erro:**
```json
{
    "erro": {
        "codigo": 400,
        "mensagem": "Descrição do erro",
        "timestamp": "2024-06-07T18:30:52-03:00"
    },
    "dados": null
}
```

**Formato de Sucesso:**
```json
{
    "erro": null,
    "dados": {
        // dados retornados
    }
}
```

## 🧪 Exemplos de Teste com cURL

### 1. Login
```bash
curl -X POST http://localhost:8080/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@teste.com",
    "senha": "123456"
  }'
```

### 2. Listar Receitas (com token)
```bash
curl -X GET http://localhost:8080/receita/listar \
  -H "Authorization: Bearer SEU_TOKEN_AQUI"
```

### 3. Criar Nova Receita
```bash
curl -X POST http://localhost:8080/receita/inserir \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN_AQUI" \
  -d '{
    "nome": "Sopa Apocalíptica",
    "descricao": "Sopa nutritiva para sobreviventes",
    "modo_preparo": "Ferva todos os ingredientes por 30 minutos",
    "tempo_preparo": 30,
    "porcoes": 4
  }'
```

### 4. Criar Ingrediente
```bash
curl -X POST http://localhost:8080/ingrediente/inserir \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN_AQUI" \
  -d '{
    "nome": "Batata",
    "unidade_medida": "kg"
  }'
```

## 🔒 Fluxo de Autenticação

1. **Login:** Fazer POST `/auth/login` com email e senha
2. **Obter Token:** Extrair o token da resposta
3. **Usar Token:** Incluir header `Authorization: Bearer {token}` em todas as requisições protegidas
4. **Renovar:** Token expira em 1 hora, fazer novo login quando necessário

## 📚 Referências

- JWT: [https://jwt.io/](https://jwt.io/)
- REST API Best Practices: HTTP Status Codes, Headers, Authentication
- Bearer Token Authentication Standard

## 🚨 Observações Importantes

1. **IDs dinâmicos**: Os IDs nos exemplos (1, 2, etc.) devem ser substituídos pelos IDs reais retornados pelas consultas
2. **Validações**: A API valida campos obrigatórios e formatos de dados
3. **Dados de exemplo**: A API já vem com dados pré-carregados para teste
4. **Relacionamentos**: Não é possível excluir receitas/ingredientes que possuem relacionamentos ativos
5. **Expiração do Token**: Tokens JWT expiram em 1 hora - faça novo login quando necessário
6. **Headers obrigatórios**: Sempre incluir `Content-Type: application/json` em POST/PUT
7. **CORS**: Headers CORS já configurados para desenvolvimento local

## 🐛 Troubleshooting

### **Problemas Comuns:**

#### 🔌 Connection Refused
- Verifique se o Docker está rodando: `docker-compose up -d`
- Confirme se os containers estão ativos: `docker ps`

#### 🚫 401 Unauthorized
- Token JWT ausente ou inválido
- Token expirado (1 hora de validade)
- Faça novo login para obter token válido

#### 📝 400 Bad Request
- Verifique o formato JSON do body
- Confirme campos obrigatórios
- Valide tipos de dados (números, strings)

#### 🔍 404 Not Found
- Confirme a URL base (`http://localhost:8080`)
- Verifique se o endpoint existe
- IDs devem existir no banco de dados

#### 💥 500 Internal Server Error
- Verifique logs do container: `docker logs catalogoreceitas-php-1`
- Problemas de conexão com banco de dados
- Erros de sintaxe ou lógica no servidor

#### 🔐 409 Conflict
- Email já cadastrado (ao registrar usuário)
- Violação de restrições únicas no banco

### **Comandos Úteis Docker:**

```bash
# Verificar status dos containers
docker ps

# Ver logs do PHP
docker logs catalogoreceitas-php-1

# Ver logs do MySQL
docker logs catalogoreceitas-mysql-1

# Reiniciar containers
docker-compose restart

# Parar e remover containers
docker-compose down

# Subir containers
docker-compose up -d
```

### **Teste de Conectividade:**

```bash
# Testar se API responde
curl http://localhost:8080

# Testar login
curl -X POST http://localhost:8080/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@teste.com","senha":"123456"}'
```

## 📞 Suporte

Para mais informações sobre a API:
1. Execute o endpoint `GET /` que retorna documentação completa
2. Consulte o arquivo `JWT_IMPLEMENTATION.md` para detalhes técnicos
3. Verifique o `README.md` para informações gerais do projeto
4. Use o Postman collection para testes interativos
