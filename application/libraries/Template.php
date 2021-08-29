<?php
class Template
{
    private $ci;
    function __construct()
    {
        $this->ci = &get_instance();
    }

    function render($template = NULL, $data = NULL)
    {
        if ($template != NULL) {
            $this->ci->load->view('Template/header', $data);
            $this->ci->load->view('Template/sidebar', $data);
            $this->ci->load->view('Template/topbar', $data);
            $this->ci->load->view($template, $data);
            $this->ci->load->view('Template/footer', $data);
        }
    }

    function renderAuth($template = NULL, $data = NULL)
    {
        if ($template != NULL) {
            $this->ci->load->view('Template/auth_header', $data);
            $this->ci->load->view($template);
            $this->ci->load->view('Template/auth_footer', $data);
        }
    }

    function emailAuth($data = NULL)
    {
        if ($data != NULL) {
            $this->ci->load->view('Auth/tampilanEmail', $data, TRUE);
        }
    }
}
