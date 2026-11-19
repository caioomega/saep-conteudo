// ==============================================================
// TELAPRODUTOS.JAVA - CRUD com JANELA (Java Swing)
// Formulário em cima, tabela embaixo. Clique numa linha pra editar.
// Rodar: dois cliques no rodar.bat desta pasta.
// ==============================================================
import javax.swing.*;                       // componentes de tela (JFrame, JButton...)
import javax.swing.table.DefaultTableModel; // os dados da tabela
import java.awt.*;                          // layouts (organização da tela)

public class TelaProdutos extends JFrame {   // extends JFrame = esta classe É uma janela

    // Campos do formulário
    private JTextField txtNome = new JTextField(20);
    private JTextField txtQuantidade = new JTextField(6);
    private JTextField txtMinimo = new JTextField(6);

    // Tabela: o "modelo" guarda os dados; a JTable mostra
    private DefaultTableModel modelo = new DefaultTableModel(new String[]{"ID", "Nome", "Qtd.", "Mínimo"}, 0) {
        @Override public boolean isCellEditable(int l, int c) { return false; } // não editar direto na tabela
    };
    private JTable tabela = new JTable(modelo);
    private int proximoId = 1;

    public TelaProdutos() {
        super("Cadastro de Produtos");                 // título da janela
        setDefaultCloseOperation(EXIT_ON_CLOSE);       // fechar = encerrar o programa
        setSize(650, 420);
        setLocationRelativeTo(null);                   // abre no meio da tela

        // ----- painel do formulário (FlowLayout = um do lado do outro) -----
        JPanel form = new JPanel(new FlowLayout(FlowLayout.LEFT));
        form.add(new JLabel("Nome:"));       form.add(txtNome);
        form.add(new JLabel("Qtd.:"));       form.add(txtQuantidade);
        form.add(new JLabel("Mínimo:"));     form.add(txtMinimo);

        JButton btnNovo = new JButton("Cadastrar");
        JButton btnEditar = new JButton("Salvar edição");
        JButton btnExcluir = new JButton("Excluir");
        JButton btnLimpar = new JButton("Limpar");
        JPanel botoes = new JPanel(new FlowLayout(FlowLayout.LEFT));
        botoes.add(btnNovo); botoes.add(btnEditar); botoes.add(btnExcluir); botoes.add(btnLimpar);

        JPanel topo = new JPanel(new GridLayout(2, 1));
        topo.add(form);
        topo.add(botoes);

        // BorderLayout: NORTH (em cima), CENTER (meio, ocupa o resto)
        setLayout(new BorderLayout());
        add(topo, BorderLayout.NORTH);
        add(new JScrollPane(tabela), BorderLayout.CENTER);  // JScrollPane = barra de rolagem

        // ----- O QUE CADA BOTÃO FAZ (e -> ... é uma "ação") -----
        btnNovo.addActionListener(e -> cadastrar());
        btnEditar.addActionListener(e -> editar());
        btnExcluir.addActionListener(e -> excluir());
        btnLimpar.addActionListener(e -> limpar());

        // Clicou numa linha da tabela -> joga os dados no formulário
        tabela.getSelectionModel().addListSelectionListener(e -> {
            int linha = tabela.getSelectedRow();
            if (linha >= 0) {
                txtNome.setText(modelo.getValueAt(linha, 1).toString());
                txtQuantidade.setText(modelo.getValueAt(linha, 2).toString());
                txtMinimo.setText(modelo.getValueAt(linha, 3).toString());
            }
        });

        // Dados iniciais
        modelo.addRow(new Object[]{proximoId++, "Martelo", 8, 3});
        modelo.addRow(new Object[]{proximoId++, "Furadeira", 2, 3});
        modelo.addRow(new Object[]{proximoId++, "Alicate", 15, 5});
    }

    // Valida e devolve {qtd, minimo}, ou null se tiver erro (e mostra a mensagem)
    private int[] validar() {
        if (txtNome.getText().trim().isEmpty()) {
            JOptionPane.showMessageDialog(this, "O nome é obrigatório.", "Erro", JOptionPane.ERROR_MESSAGE);
            return null;
        }
        try {
            int qtd = Integer.parseInt(txtQuantidade.getText().trim());
            int min = Integer.parseInt(txtMinimo.getText().trim());
            if (qtd < 0 || min < 0) throw new NumberFormatException();
            return new int[]{qtd, min};
        } catch (NumberFormatException ex) {
            JOptionPane.showMessageDialog(this, "Quantidade e mínimo têm que ser números inteiros (0 ou mais).", "Erro", JOptionPane.ERROR_MESSAGE);
            return null;
        }
    }

    private void alertaSeBaixo(String nome, int qtd, int min) {
        if (qtd < min) {
            JOptionPane.showMessageDialog(this, nome + " está abaixo do estoque mínimo!", "Alerta", JOptionPane.WARNING_MESSAGE);
        }
    }

    private void cadastrar() {
        int[] v = validar();
        if (v == null) return;
        String nome = txtNome.getText().trim();
        modelo.addRow(new Object[]{proximoId++, nome, v[0], v[1]});
        alertaSeBaixo(nome, v[0], v[1]);
        limpar();
    }

    private void editar() {
        int linha = tabela.getSelectedRow();
        if (linha < 0) {
            JOptionPane.showMessageDialog(this, "Clique num produto da tabela primeiro.");
            return;
        }
        int[] v = validar();
        if (v == null) return;
        String nome = txtNome.getText().trim();
        modelo.setValueAt(nome, linha, 1);
        modelo.setValueAt(v[0], linha, 2);
        modelo.setValueAt(v[1], linha, 3);
        alertaSeBaixo(nome, v[0], v[1]);
    }

    private void excluir() {
        int linha = tabela.getSelectedRow();
        if (linha < 0) {
            JOptionPane.showMessageDialog(this, "Clique num produto da tabela primeiro.");
            return;
        }
        int resposta = JOptionPane.showConfirmDialog(this, "Tem certeza que deseja excluir?", "Confirmar", JOptionPane.YES_NO_OPTION);
        if (resposta == JOptionPane.YES_OPTION) {
            modelo.removeRow(linha);
            limpar();
        }
    }

    private void limpar() {
        txtNome.setText(""); txtQuantidade.setText(""); txtMinimo.setText("");
        tabela.clearSelection();
    }

    public static void main(String[] args) {
        // Abre a janela do jeito certo (na "thread" da tela)
        SwingUtilities.invokeLater(() -> new TelaProdutos().setVisible(true));
    }
}
