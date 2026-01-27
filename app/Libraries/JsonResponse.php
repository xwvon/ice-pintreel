<?php
/**
 *
 * @author    liuchunhua<448455556@qq.com>
 * @date      2021/3/31
 * @copyright Canton Univideo
 */

namespace App\Libraries;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\QueryException;
use stdClass;
use Throwable;

/**
 *
 * Class JsonResponse
 *
 *
 * @package App\Librarys
 * @property integer $code
 * @property string $message
 * @property array|stdClass $data
 * @property array $debug
 * @property
 * @author  liuchunhua<448455556@qq.com>
 * @date    2021/3/31
 */
class JsonResponse implements Arrayable, Jsonable
{
    const CODE_SUCCESS = 20000;
    const CODE_ERROR   = 0;
    const MSG_SUCCESS  = 'ok';
    const MSG_ERROR    = 'err';
    public static $codeText = [

        0     => self::MSG_ERROR,
        20000 => self::MSG_SUCCESS,

    ];
    /**
     * @var JsonResponse
     */
    private static $instance;

    private $code    = self::CODE_SUCCESS;
    private $message = self::MSG_SUCCESS;
    private $data    = [];
    private $debug   = [];

    private $keys = ['code' => 'code', 'msg' => 'message', 'data' => 'data'];

    /**
     *
     *
     * @return JsonResponse
     *
     * @author liuchunhua<448455556@qq.com>
     * @date   2021/4/9
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function exception(Throwable $e)
    {
        $this->debug['exception'] = [

            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),

        ];

        if ($e instanceof QueryException) {

            $b   = $e->getBindings();
            $sql = $e->getSql();

            $sql                             = vsprintf(str_replace('?', "'%s'", $sql), $b);
            $this->debug['exception']['sql'] = $sql;
        }
    }

    public function __toString()
    {
        return $this->toJson();
    }

    public function toJson($options = JSON_UNESCAPED_UNICODE)
    {
        return json_encode($this->toArray(), $options);
    }

    public function toArray()
    {

        $d = [

            $this->keys['code'] => $this->code,
            $this->keys['msg']  => $this->message,
            $this->keys['data'] => $this->data,

        ];

        if (config('app.debug') === true) {
            $d['debug'] = $this->debug;
        }

        return $d;
    }
}
