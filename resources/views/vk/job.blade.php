{{ (!empty($title)) ? $title : ''}} @ {{(!empty($company)) ? $company : ''}}{{"\r\n"}}
Обязанности:{{"\r\n"}}
{{ (!empty($duties)) ? strip_tags($duties) : ''}}{{"\r\n"}}
Требования:{{"\r\n"}}
{{ (!empty($demand)) ? strip_tags($demand) : ''}}{{"\r\n"}}
Опыт работы:{{"\r\n"}}
{{ (!empty($experience)) ? strip_tags($experience) : ''}}{{"\r\n"}}
График работы:{{"\r\n"}}
{{ (!empty($working_schedule)) ? strip_tags($working_schedule) : ''}}{{"\r\n"}}
Условия работы:{{"\r\n"}}
{{ (!empty($condition)) ? strip_tags($condition) : ''}}{{"\r\n"}}
Заработная плата: {{(!empty($salary)) ? $salary : ''}}{{"\r\n"}}
Телефон: {{(!empty($phone)) ? $phone : ''}}{{"\r\n"}}
E-mail: {{(!empty($email)) ? $email : ''}}{{"\r\n"}}
Сайт: {{(!empty($site)) ? $site : ''}}{{"\r\n"}}
Адрес: {{(!empty($address)) ? $address : ''}}{{"\r\n"}}