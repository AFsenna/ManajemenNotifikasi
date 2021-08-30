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
            $this->ci->load->view('template/header', $data);
            $this->ci->load->view('template/sidebar', $data);
            $this->ci->load->view('template/topbar', $data);
            $this->ci->load->view($template, $data);
            $this->ci->load->view('template/footer', $data);
        }
    }

    function renderAuth($template = NULL, $data = NULL)
    {
        if ($template != NULL) {
            $this->ci->load->view('template/auth_header', $data);
            $this->ci->load->view($template);
            $this->ci->load->view('template/auth_footer', $data);
        }
    }
}
