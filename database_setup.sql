-- Script para criação do banco de dados "Catálogo de Receitas Apocalípticas"
-- Execute este script para criar as tabelas necessárias

CREATE DATABASE IF NOT EXISTS receitas_apocalipticas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE receitas_apocalipticas;

-- Configurar charset para a sessão
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Tabela de receitas
CREATE TABLE receitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    dificuldade ENUM('Fácil', 'Média', 'Difícil') NOT NULL,
    tempo_preparo INT NOT NULL COMMENT 'Tempo em minutos',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de ingredientes
CREATE TABLE ingredientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de relacionamento receita-ingrediente (many-to-many)
CREATE TABLE receita_ingrediente (
    receita_id INT,
    ingrediente_id INT,
    quantidade VARCHAR(50) COMMENT 'Ex: 200g, 1 xícara, a gosto',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (receita_id, ingrediente_id),
    FOREIGN KEY (receita_id) REFERENCES receitas(id) ON DELETE CASCADE,
    FOREIGN KEY (ingrediente_id) REFERENCES ingredientes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Limpeza de dados existentes (remover todos os dados das tabelas)
-- A ordem é importante devido às chaves estrangeiras
DELETE FROM receita_ingrediente;
DELETE FROM receitas;
DELETE FROM ingredientes;

-- Resetar AUTO_INCREMENT para começar do ID 1
ALTER TABLE receitas AUTO_INCREMENT = 1;
ALTER TABLE ingredientes AUTO_INCREMENT = 1;

-- Inserção de dados de exemplo
INSERT INTO receitas (titulo, descricao, dificuldade, tempo_preparo) VALUES
('Sopa do Fim do Mundo', 'Uma sopa nutritiva feita com ingredientes não perecíveis, perfeita para sobreviventes do apocalipse.', 'Fácil', 30),
('Ensopado de Sobrevivência', 'Ensopado robusto com carne enlatada e vegetais desidratados.', 'Média', 45),
('Pão de Guerra', 'Pão denso e nutritivo que dura semanas sem estragar.', 'Difícil', 120),
('Pasta Energética', 'Mistura calórica para recuperar energias rapidamente.', 'Fácil', 10),
('Feijão Trepeiro', 'Feijão especial que sobe pelas paredes e invade todos os cantos da panela, impossível de resistir.', 'Média', 60),
('Salsicha Maliciosa', 'Salsicha grossa e suculenta que explode de sabor na boca, deixando todos satisfeitos.', 'Fácil', 25),
('Ovo Provocante', 'Ovos mexidos de forma especial que fazem qualquer um gemer de prazer ao primeiro gosto.', 'Fácil', 15),
('Banana Safada', 'Sobremesa cremosa e escorregadia que derrete na língua de forma irresistível.', 'Média', 40),
('Linguiça Pervertida', 'Linguiça grossa temperada com especiarias que fazem suar de tanto prazer.', 'Média', 35);

INSERT INTO ingredientes (nome) VALUES
('Carne Enlatada'),
('Feijão Enlatado'),
('Arroz'),
('Água Purificada'),
('Sal'),
('Vegetais Desidratados'),
('Farinha de Trigo'),
('Óleo'),
('Açúcar'),
('Mel'),
('Nozes'),
('Frutas Secas'),
('Feijão Safado'),
('Linguiça Gostosa'),
('Bacon Malicioso'),
('Cebola Provocante'),
('Alho Excitante'),
('Pimenta Sedutora'),
('Cheiro-Verde Malandro'),
('Salsicha Grossa'),
('Ovo Cremoso'),
('Leite Condensado Escorregadio'),
('Banana Madura'),
('Canela Quente'),
('Açúcar Cristal Molhado'),
('Manteiga Derretida'),
('Queijo Grudento'),
('Presunto Suculento');

-- Relacionamentos de exemplo
INSERT INTO receita_ingrediente (receita_id, ingrediente_id, quantidade) VALUES
(1, 1, '1 lata'),  -- Sopa: Carne Enlatada
(1, 2, '1 lata'),  -- Sopa: Feijão Enlatado
(1, 4, '500ml'),   -- Sopa: Água Purificada
(1, 5, 'a gosto'), -- Sopa: Sal
(2, 1, '2 latas'), -- Ensopado: Carne Enlatada
(2, 6, '50g'),     -- Ensopado: Vegetais Desidratados
(2, 4, '1 litro'), -- Ensopado: Água Purificada
(3, 7, '500g'),    -- Pão: Farinha de Trigo
(3, 4, '300ml'),   -- Pão: Água Purificada
(3, 5, '1 colher de chá'), -- Pão: Sal
(4, 10, '200g'),   -- Pasta: Mel
(4, 11, '100g'),   -- Pasta: Nozes
(4, 12, '100g'),   -- Pasta: Frutas Secas
-- Feijão Trepeiro
(5, 13, '500g'),   -- Feijão Safado
(5, 14, '200g'),   -- Linguiça Gostosa
(5, 15, '150g'),   -- Bacon Malicioso
(5, 16, '1 unidade grande'), -- Cebola Provocante
(5, 17, '3 dentes'), -- Alho Excitante
(5, 18, '1 pitada'), -- Pimenta Sedutora
(5, 19, 'a gosto'), -- Cheiro-Verde Malandro
(5, 4, '1 litro'), -- Água Purificada
(5, 8, '2 colheres de sopa'), -- Óleo
-- Salsicha Maliciosa
(6, 20, '4 unidades'), -- Salsicha Grossa
(6, 16, '1 média'), -- Cebola Provocante
(6, 17, '2 dentes'), -- Alho Excitante
(6, 8, '2 colheres'), -- Óleo
(6, 5, 'a gosto'), -- Sal
(6, 18, 'a gosto'), -- Pimenta Sedutora
-- Ovo Provocante
(7, 21, '6 unidades'), -- Ovo Cremoso
(7, 26, '2 colheres'), -- Manteiga Derretida
(7, 5, 'a gosto'), -- Sal
(7, 18, 'uma pitadinha'), -- Pimenta Sedutora
(7, 19, 'para finalizar'), -- Cheiro-Verde Malandro
-- Banana Safada
(8, 23, '3 unidades'), -- Banana Madura
(8, 22, '1 lata'), -- Leite Condensado Escorregadio
(8, 24, '1 colher de chá'), -- Canela Quente
(8, 25, '2 colheres'), -- Açúcar Cristal Molhado
-- Linguiça Pervertida
(9, 14, '500g'),   -- Linguiça Gostosa
(9, 16, '2 grandes'), -- Cebola Provocante
(9, 17, '4 dentes'), -- Alho Excitante
(9, 18, '2 pimentas'), -- Pimenta Sedutora
(9, 8, '3 colheres'), -- Óleo
(9, 5, 'a gosto'); -- Sal

-- Verificação dos dados inseridos
SELECT 'Receitas criadas:' as info;
SELECT id, titulo, dificuldade, tempo_preparo FROM receitas;

SELECT 'Ingredientes criados:' as info;
SELECT id, nome FROM ingredientes;

SELECT 'Relacionamentos criados:' as info;
SELECT 
    r.titulo as receita,
    i.nome as ingrediente,
    ri.quantidade
FROM receita_ingrediente ri
JOIN receitas r ON ri.receita_id = r.id
JOIN ingredientes i ON ri.ingrediente_id = i.id
ORDER BY r.titulo, i.nome;
