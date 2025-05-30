# 📋 Collection Postman - API Receitas Apocalípticas

Esta collection contém todos os endpoints para testar a API de Receitas Apocalípticas.

## 📥 Como Importar no Postman

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

## 📚 Estrutura da Collection

### 🏠 **Informações da API**
- `GET /` - Retorna informações sobre todos os endpoints

### 🍽️ **RECEITAS**
- `GET /receita` - Listar todas as receitas
- `GET /receita/{id}` - Obter receita específica
- `POST /receita` - Criar nova receita
- `PUT /receita/{id}` - Atualizar receita
- `DELETE /receita/{id}` - Excluir receita

### 🥕 **INGREDIENTES**
- `GET /ingrediente` - Listar todos os ingredientes
- `GET /ingrediente/{id}` - Obter ingrediente específico
- `POST /ingrediente` - Criar novo ingrediente
- `PUT /ingrediente/{id}` - Atualizar ingrediente
- `DELETE /ingrediente/{id}` - Excluir ingrediente

### 🔗 **RELACIONAMENTO RECEITA-INGREDIENTE**
- `GET /receita/{id}/ingredientes` - Listar ingredientes de uma receita
- `POST /receita/{id}/ingredientes` - Adicionar ingrediente à receita
- `DELETE /receita/{id}/ingredientes/{ingrediente_id}` - Remover ingrediente da receita

### 🧪 **TESTES DE VALIDAÇÃO**
Endpoints para testar cenários de erro e validação:
- Receita com dificuldade inválida
- Receita com tempo inválido
- Ingrediente sem nome
- Buscar receita inexistente

### 🚀 **WORKFLOW COMPLETO**
Sequência de testes para um fluxo completo:
1. Criar ingrediente base
2. Criar receita completa
3. Vincular ingrediente à receita
4. Verificar receita com ingredientes

## 🎯 Como Usar

### **Antes de começar:**
1. Certifique-se de que o Docker está rodando: `docker-compose up -d`
2. Verifique se a API está disponível em: `http://localhost:8080`

### **Sequência recomendada de testes:**

1. **📋 Verificar API**: Execute "Informações da API" para confirmar que está funcionando
2. **👀 Explorar dados**: Execute "Listar receitas" e "Listar ingredientes" para ver dados existentes
3. **➕ Criar dados**: Use os endpoints POST para criar novos ingredientes e receitas
4. **🔗 Relacionar**: Use os endpoints de relacionamento para vincular ingredientes às receitas
5. **✏️ Atualizar**: Teste os endpoints PUT para modificar dados
6. **🗑️ Excluir**: Teste os endpoints DELETE (cuidado com dados importantes!)

### **Estrutura dos dados:**

#### **Receita:**
```json
{
    "titulo": "Nome da receita",
    "descricao": "Descrição detalhada",
    "dificuldade": "Fácil|Média|Difícil",
    "tempo_preparo": 30
}
```

#### **Ingrediente:**
```json
{
    "nome": "Nome do ingrediente"
}
```

#### **Relacionamento:**
```json
{
    "ingrediente_id": 2
}
```

## 🔧 Configurações

### **URL Base:**
- Local: `http://localhost:8080`
- Produção: Altere a variável `baseUrl` no environment

### **Headers:**
Todos os endpoints POST/PUT já estão configurados com:
- `Content-Type: application/json`

## 🚨 Observações Importantes

1. **IDs dinâmicos**: Os IDs nos exemplos (1, 2, etc.) devem ser substituídos pelos IDs reais retornados pelas consultas
2. **Validações**: A API valida campos obrigatórios e formatos
3. **Dados de exemplo**: A API já vem com dados pré-carregados para teste
4. **Relacionamentos**: Não é possível excluir receitas/ingredientes que possuem relacionamentos ativos

## 🐛 Resolução de Problemas

- **Connection refused**: Verifique se o Docker está rodando
- **404 Not Found**: Confirme a URL base e o endpoint
- **400 Bad Request**: Verifique o formato JSON e campos obrigatórios
- **500 Internal Error**: Verifique os logs do container PHP

## 📞 Suporte

Para mais informações sobre a API, execute o endpoint de informações da API que retorna a documentação completa dos endpoints disponíveis.
