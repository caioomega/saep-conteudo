<?php
// ==============================================================
// EXEMPLO-POO.PHP - os 4 pilares da Orientação a Objetos em PHP
// Abra: localhost/18-poo-orientacao-objetos/exemplo-poo.php
// ==============================================================

// ---------- CLASSE + ENCAPSULAMENTO ----------
// Classe = molde. Objeto = coisa criada a partir do molde.
class Produto {
    // private: ninguém de fora mexe direto (ENCAPSULAMENTO)
    private string $nome;
    private int $quantidade;
    // protected: a classe e as FILHAS podem mexer
    protected float $preco;

    // Construtor: roda no "new"
    public function __construct(string $nome, int $quantidade, float $preco) {
        $this->nome = $nome;           // $this = "este objeto"
        $this->setQuantidade($quantidade);
        $this->preco = $preco;
    }

    // Getter e setter (com validação dentro!)
    public function getNome(): string { return $this->nome; }
    public function getQuantidade(): int { return $this->quantidade; }
    public function setQuantidade(int $q): void {
        if ($q < 0) {
            throw new Exception("Quantidade não pode ser negativa");
        }
        $this->quantidade = $q;
    }

    // Método que vai ser SOBRESCRITO na classe filha (POLIMORFISMO)
    public function calcularPreco(): float {
        return $this->preco;
    }

    public function descricao(): string {
        return $this->nome . " - R$ " . number_format($this->calcularPreco(), 2, ',', '.');
    }
}

// ---------- HERANÇA ----------
// ProdutoPromocional É UM Produto (herda tudo) + tem desconto
class ProdutoPromocional extends Produto {
    private float $desconto;

    public function __construct(string $nome, int $quantidade, float $preco, float $desconto) {
        parent::__construct($nome, $quantidade, $preco);   // chama o construtor do pai
        $this->desconto = $desconto;
    }

    // POLIMORFISMO: mesmo método, comportamento diferente
    public function calcularPreco(): float {
        return $this->preco * (1 - $this->desconto / 100);
    }
}

// ---------- ABSTRAÇÃO (interface) ----------
// Interface = um "contrato": quem implementa É OBRIGADO a ter esses métodos
interface Exportavel {
    public function exportar(): string;
}

class Relatorio implements Exportavel {
    public function exportar(): string {
        return "Relatório exportado!";
    }
}

// ================== USANDO ==================
$p1 = new Produto("Martelo", 8, 40.00);
$p2 = new ProdutoPromocional("Furadeira", 2, 300.00, 10);   // 10% de desconto

echo $p1->descricao() . "<br>";    // Martelo - R$ 40,00
echo $p2->descricao() . "<br>";    // Furadeira - R$ 270,00

// Polimorfismo na prática: trato todos como "Produto"
$lista = [$p1, $p2];
foreach ($lista as $p) {
    echo get_class($p) . ": " . $p->calcularPreco() . "<br>";
}

// Encapsulamento protegendo o dado:
try {
    $p1->setQuantidade(-5);
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "<br>";
}

echo (new Relatorio())->exportar() . "<br>";
?>
