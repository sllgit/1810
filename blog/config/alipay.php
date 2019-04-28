<?php
return [
    //应用ID,您的APPID。
    'app_id' => "2016092500595501",

    //商户私钥
    'merchant_private_key' => "MIIEpQIBAAKCAQEAz2Mcb9cZ1WovJeb7rnuX/7KebEHPrX52mr4pXUEvS9eYdKgx+3ij70jezoqyLB7Fmzd5mm0YjuvfwkcIt+G24fPX15Zl4L3uVhzEx4xstINfC/2EhTlIsEqLPncxSa7CwHCz5yETG+6RJZU0M8mhJorWh5JcdawqxMAqz/MVFtHOHH45r+O6OEG6UEsHB7/UyLD74X97y9culJFKJIPri/QALKs6k50KzePc6udUxWjIFlGzVJYdzYVrVLWXM9o79OPeFL6PLZ99EGZHTaGf7BGqTqptNbzLpnZIJ4y06ti+JV1B3T3zsqjA1+OeWZXe1IC2eUmOJWEjqxU8qXhABwIDAQABAoIBAAwitZhJ0wYtB4NFR/cG3nclAaY+F6QEYXZeqFb/qH/cptw0t3AKuDUZY4hcj16Lkm6pyWDi/2vlm5tnwrfX6nbAaSIBeAa1toutdUpkCjxp75bpB+cv2fQO+KT4Hpc8NcNDFRPyWIbq5+12FK7vHpH9z93xD54HLB2FTTwL8nD6TQCmJa2d+1y1rXE3+GrQXr15PDNvwC4z0v9H/Hg3oWjSpNyMRbX4uUbPWJLbbuekffVeCmAsw65Z2YpFBLcT78HsVcTREX3WlBzJrnnhaWdH56uesZFDHfdIYq89Jmhc97egg3GVn7msy+whnJ8R30ZBAOyR1Erm1hvJysVDtekCgYEA8fPwoScXMANVH3kWAI3GgsZ2dOpafZ34kdcUAMAax1etRPeqJ8jG7uTPlawo5M7gnROS78lfnOhJKv/wGoXypPqFWnk4wtv3F67ZrB8G1qSawj+kX+/TUdeXwKB5JduQ9U5nmyYThkyXiNdqaMjKYozM6Uk1EmkQGSfJ6w0W/hMCgYEA221uzPOgng2ajfbSHuw0F+Bz9P9Kqt+zaMyCk6zl/tvTAGruodQ4OGDtVdm+yXl517Ytys45Yi5colFDUYzRcEUxnAd5XINRWkaHHWF6dWPymqf/oYknaGzrFM2lX0vvMniN+mr+0Qq2qTiCxYHxT9BUEKMt/g57S59nc5WsJL0CgYEA5aIYJ1rqbu86wvwxHaVxWnzxwFUMPVzIpeHzYiLxR3C3SlWkcM3lwKX5Ppx+02plU69YLax5ynnLt7vhLcsjV+FM32ldrdMG2LtibDGmU+E14FZ2s3byoSJ1LKUhVgTlt2wKeP3SWgwnZgDNRVYMfywS7vZEII0GclmJEkUCJXECgYEAsDrMwWhtuGLenWP9T/6OvBp1pvAebOwrMGEIAkjbk3vDlFNNgsVpvcYC929hLnkUpW3Yi0hjh/oKRgcUFPwO/adk95Z9HxMMlH+OZsdyTbPPFe0VfwwjjVfk2hlr1wSqgJOYG+Yw7302RORxCuWZBGwiCBa2ipPg7FSDBq7PydUCgYEAwE6z8LS8f3nDeFB9Ik58soDessZbac7FXFgz+tLwSCZJG+CrcY5t9CPytztftEPvL0zfe5vVmEFWp8o31Euehuq5G9BkApcGft3MwOx0x1lKCkcEJEynvpWm2UXGvVY3Jobwg/vvTiwN7HhHR1r8djUWVVUiWgzcWjtYfJLMjXw=",
    //异步通知地址
    'notify_url' => "http://47.93.2.112/zhubao/notify",

    //同步跳转
    'return_url' => "http://47.93.2.112/zhubao/returnpay",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAseJwOfWDgk+2OmsRSZ19siG+VDA/KVr/anVL5MEv9CEHdGENuPEPVd36uN26wNbuOn+v/6+R6QM3SCuicHt3MLun7MYO4+myvQiK08v6pY/Twf5ktwQfxfHP9K4qS9Z1Sqq4y8pN3vU2H+B9Hb6SybRs9u/tTamFKVSNAyUojm8f6kZPxrSGg2hl7Hlv64a27MHCuo4AFu3Fejz3lWVWySNUkvLkNJDYZu9nL3/WCCZfF95FH4/6jBT/SSZd5/LOQW7/fTjtIZN2GflG9Pt0Al8AUvpHU2HjJnmWYAgibwY988d7tU3Qf26HeKOtNpSv/0NIMkVZCJg9bI9Ftrsa6QIDAQAB",
    'seller_id'=>'2088102177251776',
];