<?php

namespace Member\Model\Add;

use Zend\InputFilter\InputFilterProviderInterface;
use Zend\InputFilter\Input;
use Zend\Filter\StringTrim;
use Zend\I18n\Validator\Alnum;
use Zend\Validator\StringLength;

class InputSpec implements InputFilterProviderInterface
{
    public function getInputFilterSpecification()
    {
        return [
            $this->loginId(),
            $this->password(),
            $this->passwordConfirmation(),
            $this->name(),
            $this->nameKana(),
            $this->mailAddress(),
            $this->birthday(),
            $this->businessClassificationId()
        ];
    }

    public function loginId()
    {
        $input = new Input('login_id');

        // $input->getFilterChain()
        //     ->attach(new StringTrim());

        $input->getValidatorChain()
            ->attach(new StringLength(['min'=> 4, 'max' => 16]));
        //     ->attach(new Alnum());

/*            ->attach(
                Validators::callback(function ($id) {
                    return !$this->service->loginIdExists($id);
                })->setMessage('既に使用されています。')
            );
 */
        return $input;
    }

    public function password()
    {
        $input = new Input('password');
        $input->getValidatorChain()
            ->attach(new StringLength(['min'=> 2, 'max' => 4]));
        return $input;
    }

    public function passwordConfirmation()
    {
        $input = new Input('password_confirmation');
        $input->getValidatorChain()
            ->attach(new StringLength(['min'=> 2, 'max' => 4]));
        return $input;
    }

    public function name()
    {
        $input = new Input('name');
        $input->getValidatorChain()
            ->attach(new StringLength(['max'=> 4]));
        return $input;
    }

    public function nameKana()
    {
        $input = new Input('name_kana');
        $input->getValidatorChain()
            ->attach(new StringLength(['max'=> 4]));
        return $input;
    }

    public function mailAddress()
    {
        $input = new Input('mail_address');
        $input->getValidatorChain()
            ->attach(new StringLength(['max'=> 4]));
        return $input;
    }

    public function birthday()
    {
        $input = new Input('birthday');
        return $input;
    }

    public function businessClassificationId()
    {
        $input = new Input('business_classification_id');
        return $input;
    }
}
