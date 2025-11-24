
<?php
class PacienteLogic
{
    private $xmlFile;

    public function __construct()
    {
        $this->xmlFile = __DIR__ . '/../data/pacientes.xml';
        if (!file_exists($this->xmlFile)) {
            file_put_contents($this->xmlFile, "<?xml version=\"1.0\"?><pacientes></pacientes>");
        }
    }

    public function RegistrarPaciente($cedula, $nombre, $apellido, $telefono, $email)
    {
        $xml = $this->loadXml();
        if ($this->findPacienteNode($xml, $cedula)) {
            return false; // ya existe
        }
        $p = $xml->addChild('paciente');
        $p->addChild('cedula', $cedula);
        $p->addChild('nombre', $nombre);
        $p->addChild('apellido', $apellido);
        $p->addChild('telefono', $telefono);
        $p->addChild('email', $email);
        return $this->saveXml($xml);
    }

    public function BuscarPacientePorCedula($cedula)
    {
        $xml = $this->loadXml();
        $n = $this->findPacienteNode($xml, $cedula);
        return $n ? $this->nodeToPaciente($n) : null;
    }

    public function ListarTodosLosPacientes()
    {
        $xml = $this->loadXml();
        $result = [];
        foreach ($xml->paciente as $p) {
            $result[] = $this->nodeToPaciente($p);
        }
        return $result;
    }

    public function ModificarPaciente($cedula, $nombre, $apellido, $telefono, $email)
    {
        $xml = $this->loadXml();
        $n = $this->findPacienteNode($xml, $cedula);
        if (!$n) {
            return false;
        }
        $n->nombre = $nombre;
        $n->apellido = $apellido;
        $n->telefono = $telefono;
        $n->email = $email;
        return $this->saveXml($xml);
    }

    public function EliminarPaciente($cedula)
    {
        $xml = $this->loadXml();
        $dom = dom_import_simplexml($xml);
        foreach ($xml->paciente as $p) {
            if ((string)$p->cedula === (string)$cedula) {
                $domNode = dom_import_simplexml($p);
                $domNode->parentNode->removeChild($domNode);
                return $this->saveXml(simplexml_import_dom($dom));
            }
        }
        return false;
    }

    private function loadXml()
    {
        return simplexml_load_file($this->xmlFile);
    }

    private function saveXml($xml)
    {
        $tmp = tempnam(sys_get_temp_dir(), 'pac');
        $ok = $xml->asXML($tmp);
        if ($ok) {
            return rename($tmp, $this->xmlFile);
        }
        return false;
    }

    private function findPacienteNode($xml, $cedula)
    {
        foreach ($xml->paciente as $p) {
            if ((string)$p->cedula === (string)$cedula) {
                return $p;
            }
        }
        return null;
    }

    private function nodeToPaciente($n)
    {
        return [
            'cedula' => (string)$n->cedula,
            'nombre' => (string)$n->nombre,
            'apellido' => (string)$n->apellido,
            'telefono' => (string)$n->telefono,
            'email' => (string)$n->email,
        ];
    }
}

