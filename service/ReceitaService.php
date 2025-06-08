<?php
namespace service;

use dao\mysql\ReceitaDAO;

use Exception;

class ReceitaService extends ReceitaDAO {
    
    private $dificuldadesValidas = ['Fácil', 'Média', 'Difícil'];    public function listarReceitas() {
        try {
            return parent::listar();
        } catch (Exception $e) {
            return [
                'erro' => 'Erro ao buscar receitas',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }

    public function inserir($titulo, $descricao, $dificuldade, $tempo_preparo) {
        try {
            if (!$this->validarDificuldade($dificuldade)) {
                return [
                    'erro' => "Dificuldade deve ser 'Fácil', 'Média' ou 'Difícil'. Recebido: '" . $dificuldade . "'",
                    'codigo' => 400,
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }
            
            if (!$this->validarTempoPreparo($tempo_preparo)) {
                return [
                    'erro' => 'Tempo de preparo deve ser um número positivo',
                    'codigo' => 400,
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }

            if (parent::inserir($titulo, $descricao, $dificuldade, $tempo_preparo)) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Receita salva com sucesso!',
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }
            
            return [
                'erro' => 'Erro ao salvar receita',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
        } catch (Exception $e) {
            return [
                'erro' => 'Erro interno do servidor',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }

    public function alterar($id, $titulo, $descricao, $dificuldade, $tempo_preparo) {
        try {
            if (!$this->validarDificuldade($dificuldade)) {
                return [
                    'erro' => "Dificuldade deve ser 'Fácil', 'Média' ou 'Difícil'",
                    'codigo' => 400,
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }
            
            if (!$this->validarTempoPreparo($tempo_preparo)) {
                return [
                    'erro' => 'Tempo de preparo deve ser um número positivo',
                    'codigo' => 400,
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }

            if (parent::alterar($id, $titulo, $descricao, $dificuldade, $tempo_preparo)) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Receita alterada com sucesso!',
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }
            
            return [
                'erro' => 'Erro ao alterar receita',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
        } catch (Exception $e) {
            return [
                'erro' => 'Erro interno do servidor',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }

    public function excluir($id) {
        try {
            if (parent::excluir($id)) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Receita excluída com sucesso!',
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }
            
            return [
                'erro' => 'Erro ao excluir receita',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
        } catch (Exception $e) {
            return [
                'erro' => 'Erro interno do servidor',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }

    public function listarId($id) {
        try {
            return parent::listarId($id);
        } catch (Exception $e) {
            return [
                'erro' => 'Erro ao buscar receita',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }    public function adicionarIngrediente($receita_id, $ingrediente_id) {
        try {
            if (parent::inserirReceitaIngrediente($receita_id, $ingrediente_id)) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Ingrediente adicionado à receita com sucesso!',
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }
            
            return [
                'erro' => 'Erro ao adicionar ingrediente à receita',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
        } catch (Exception $e) {
            return [
                'erro' => 'Erro interno do servidor',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }

    public function removerIngrediente($receita_id, $ingrediente_id) {
        try {
            if (parent::removerReceitaIngrediente($receita_id, $ingrediente_id)) {
                return [
                    'sucesso' => true,
                    'mensagem' => 'Ingrediente removido da receita com sucesso!',
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            }
            
            return [
                'erro' => 'Erro ao remover ingrediente da receita',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
        } catch (Exception $e) {
            return [
                'erro' => 'Erro interno do servidor',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }

    public function listarIngredientesPorReceita($receita_id) {
        try {
            return parent::listarIngredientesPorReceita($receita_id);
        } catch (Exception $e) {
            return [
                'erro' => 'Erro ao buscar ingredientes da receita',
                'codigo' => 500,
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
    }

    private function validarDificuldade($dificuldade) {
        return in_array($dificuldade, $this->dificuldadesValidas);
    }

    private function validarTempoPreparo($tempo_preparo) {
        return is_numeric($tempo_preparo) && $tempo_preparo > 0;
    }
}
