<?php

/**
 * ContactController
 *
 * Allows to contact the staff using a contact form
 */
class ContactController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Contact us');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->form = new ContactForm;
    }

    /**
     * Saves the contact information in the database
     */
    public function sendAction()
    {
        if ($this->request->isPost() != true) {
            return $this->forward('contact/index');
        }

        $form = new ContactForm;
        $contact = new Contact();

        // Validate the form
        $data = $this->request->getPost();
        if (!$form->isValid($data, $contact)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->forward('contact/index');
        }
        $notice = new Mailer('scott@huson.com', 'Feedback For Brown Bytes', serialize($data));


        $this->flash->success('Thank you for your feedback. I appreciate your help in making this application better.');
        return $this->forward('index');
    }
}
