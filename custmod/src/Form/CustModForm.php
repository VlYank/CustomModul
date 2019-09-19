<?php
/**
 * @file
 * Contains \Drupal\helloworld\Form\CollectPhone.
 *
 * В комментарии выше указываем, что содержится в данном файле.
 */

// Объявляем пространство имён формы. Drupal\НАЗВАНИЕ_МОДУЛЯ\Form
namespace Drupal\custmod\Form;

// Указываем что нам потребуется FormBase, от которого мы будем наследоваться
// а также FormStateInterface который позволит работать с данными.
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Объявляем нашу форму, наследуясь от FormBase.
 * Название класса строго должно соответствовать названию файла.
 */
class CustModForm extends FormBase {

  /**
   * То что ниже - это аннотация. Аннотации пишутся в комментариях и в них
   * объявляются различные данные. В данном случае указано, что документацию
   * к данному методу надо взять из комментария к самому классу.
   *
   * А в самом методе мы возвращаем название нашей формы в виде строки.
   * Эта строка используется для альтера формы (об этом ниже в тексте).
   *
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'collect_phone';
  }

  /**
   * Создание нашей формы.
   *
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Объявляем телефон.
    $form['first_name'] = array(
      '#type' => 'textfield',
      // Не забываем из Drupal 7, что t, в D8 $this->t() можно использовать
      // только с английскими словами. Иначе не используйте t() а пишите
      // просто строку.
      '#title' => $this->t('First name')
    );
   $form['last_name'] = array(
      '#type' => 'textfield',
      // Не забываем из Drupal 7, что t, в D8 $this->t() можно использовать
      // только с английскими словами. Иначе не используйте t() а пишите
      // просто строку.
      '#title' => $this->t('Last name')
    );
   $form['Subject'] = array(
      '#type' => 'textfield',
      // Не забываем из Drupal 7, что t, в D8 $this->t() можно использовать
      // только с английскими словами. Иначе не используйте t() а пишите
      // просто строку.
      '#title' => $this->t('Subject')
    );
     $form['Message'] = array(
      '#type' => 'textarea',
      // Не забываем из Drupal 7, что t, в D8 $this->t() можно использовать
      // только с английскими словами. Иначе не используйте t() а пишите
      // просто строку.
      '#title' => $this->t('Message')
    );
          $form['email'] = array(
      '#type' => 'textfield',
      // Не забываем из Drupal 7, что t, в D8 $this->t() можно использовать
      // только с английскими словами. Иначе не используйте t() а пишите
      // просто строку.
      '#title' => $this->t('email')
    );



    // Предоставляет обёртку для одного или более Action элементов.
    $form['actions']['#type'] = 'actions';
    // Добавляем нашу кнопку для отправки.
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Send '),
      '#button_type' => 'primary',
    );

    $query = \Drupal::database()->select('mailsDB', 'nfd');
$query->fields('nfd', ['mail', 'sub','mes']);
$result = $query->execute()->fetchAll();
    return $form;
  }

  /**
   * Валидация отправленых данных в форме.
   *
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Если длина имени меньше 5, выводим ошибку.




if (! preg_match('/@.+\./',$form_state->getValue('email'))) {
$form_state->setErrorByName('email', $this->t('wrong email')); 
} 
   

  }

  /**
   * Отправка формы.
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Мы ничего не хотим делать с данными, просто выведем их в системном
    // сообщении.
    drupal_set_message($this->t('Thank you @first_name @last_name', array(
      '@first_name' => $form_state->getValue('first_name'),
          '@last_name' => $form_state->getValue('last_name'),
          '@Subject' => $form_state->getValue('Subject'),
              '@Message' => $form_state->getValue('Message'),
      '@email' => $form_state->getValue('email')
    )));
mail($form_state->getValue('email'),$form_state->getValue('Subject'),$form_state->getValue('Message'));


     $email = $form_state->getValue('email');
    $Subject = $form_state->getValue('Subject');
    $Message = $form_state->getValue('Message');


   

    $data = array(
      'properties' => [
        [
          'property' => 'Subject',
          'value' => $Subject
        ],
        [
          'property' => 'Message',
          'value' => $Message 
        ]
      ]
    );

$arr = array(
            'properties' => array(
                array(
                    'property' => 'email',
                    'value' => $email
                ),
                array(
                    'property' => 'Subject',
                    'value' =>  $Subject
                ),
                array(
                    'property' => 'Message',
                    'value' =>  $Message
                )
            
            )
        );
  $hapikey = readline("08291b59-3bfc-4a41-ab4e-89f89378428f");
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact?hapikey=' . $hapikey;
       
    $post_json = json_encode($arr,true);

 @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        @curl_setopt($ch, CURLOPT_URL, $endpoint);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
   

  }

}