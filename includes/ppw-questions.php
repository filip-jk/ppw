<?php


class PPW_Question {

	private $questions = array(
		'q1' => array (
			'value' => 'Você vende de um lugar fixo ou nas ruas?',
			'group' => 1,
			'answers' => array(
				'a1' => 'Nas ruas',
				'a2' => 'Lugar fixo',
				'a3' => 'Ambos',
				'a4' => 'Tanto Faz'
			)
		),
		'q2' => array (
			'value' => 'Volume médio de vendas no cartão',
			'group' => 1,
			'answers' => array(
				'a1' => 'até R$1 mil/mês',
				'a2' => 'R$1 mil a R$5 mil/mês',
				'a3' => 'acima de R$5mil/mês'
			)
		),
		'q3' => array (
			'value' => 'Forma de pagamento mais aceita',
			'group' => 2,
			'answers' => array(
				'a1' => 'Vendo mais no débito',
				'a2' => 'Vendo mais no crédito',
				'a3' => 'Porcentagem é parecida'
			)
		),
		'q4' => array (
			'value' => 'Parcelar é importante para você?',
			'group' => 2,
			'answers' => array(
				'a1' => 'Sim',
				'a2' => 'Não'
			)
		),
		'q5' => array (
			'value' => 'De quais bandeiras você precisa?',
			'group' => 2,
			'answers' => array(
				'a1' => 'Visa, MasterCard, Elo',
				'a2' => 'Tem que aceitar HiperCard',
				'a3' => 'Tanto Faz/Não Sei'
			)
		),
		'q6' => array (
			'value' => 'Cartão-refeição?',
			'group' => 2,
			'answers' => array(
				'a1' => 'Sim',
				'a2' => 'Não'
			)
		),
		'q7' => array (
			'value' => 'Máquina para Frente de Caixa?',
			'group' => 3,
			'answers' => array(
				'a1' => 'Sim',
				'a2' => 'Não',
				'a3' => 'Tanto Faz',
				'a4' => 'Não Sei'
			)
		),
		'q8' => array (
			'value' => 'Você tem conta bancária?',
			'group' => 3,
			'answers' => array(
				'a1' => 'Sim',
				'a2' => 'Não'
			)
		),
		'q9' => array (
			'value' => 'Em quanto tempo quer receber seu saldo?',
			'group' => 3,
			'answers' => array(
				'a1' => 'Pago mais para receber rápido',
				'a2' => 'Posso receber a cada 30 dias',
				'a3' => 'Tanto Faz/Não Sei'
			)
		),
		'q10' => array (
			'value' => 'Precisa que a máquina imprima recibo?',
			'group' => 3,
			'answers' => array(
				'a1' => 'Sim',
				'a2' => 'Não',
				'a3' => 'Tanto Faz'
			)
		)
	);

	private $answer_values = array(
		10 => '10',
		9 => '9',
		8 => '8',
		7 => '7',
		6 => '6',
		5 => '5',
		4 => '4',
		3 => '3',
		2 => '2',
		1 => '1',
		0 => 'Exclude'
	);

	private $deafult_questios_groups = 3;

	public function __construct() {

	}

	function get_all_questions() {

		return $this->questions;

	}

	function get_answer_values() {

		return $this->answer_values;

	}

	function get_default_question_groups() {

		return $this->deafult_questios_groups;

    }

}

$ppw_question = new PPW_Question();