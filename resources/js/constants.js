
const REQUEST_BODY_RAW_OPTIONS = [
    { key: 'text', value: 'text/plain', text: 'Text', },
    { key: 'json', value: 'application/json', text: 'JSON', },
    // TODO: support body raw options for XML, YAML, and EDN
];

export const REQUEST_BODY_KEYS = {
    FORM_DATA: 'form-data',
    FORM_URL_ENCODED: 'form-urlencoded',
    RAW: 'raw'
};

export const REQUEST_BODY_OPTIONS = [{
    key: 'none',
    value: null,
    text: 'none',
    options: []
}, {
    key: REQUEST_BODY_KEYS.FORM_DATA,
    value: 'multipart/form-data',
    text: 'multipart form',
    options: []
}, {
    key: REQUEST_BODY_KEYS.FORM_URL_ENCODED,
    value: 'application/x-www-form-urlencoded',
    text: 'form URL encoded',
    options: []
}, {
    key: REQUEST_BODY_KEYS.RAW,
    value: null,
    text: 'raw',
    options: REQUEST_BODY_RAW_OPTIONS
}];

export const HTTP_REQUEST_METHODS = [{
        name: 'GET',
        color: 'text-green-500'
    },
    {
        name: 'POST',
        color: 'text-blue-500'
    },
    {
        name: 'DELETE',
        color: 'text-red-600'
    },
    {
        name: 'PUT',
        color: 'text-purple-500'
    },
    {
        name: 'PATCH',
        color: 'text-blue-500'
    }
];

// forbidden header name is not included to the lists.
// sourced from:
// https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers
// https://developer.mozilla.org/en-US/docs/Glossary/Forbidden_header_name
export const HTTP_HEADER_FIELDS = {
    KEYS: [
        'Accept',
        'Authorization',
        'Accept-Language',
        'Content-MD5',
        'Cache-Control',
        'Content-Transfer-Encoding',
        'Cookie',
        'Content-Type',
        'From',
        'if-Match',
        'if-Modified-Since',
        'If-None-Match',
        'If-Range',
        'If-Unmodified-Since',
        'Max-Forwards',
        'Pragma',
        'Range',
        'User-Agent',
        'Warning',
        'X-Do-Not-Track',
        'X-Requested-With',
        'x-api-key'
    ],
    VALUES: [
        "application/atom+xml",
        "application/ecmascript",
        "application/json",
        "application/javascript",
        "application/octet-stream",
        "application/ogg",
        "application/pdf",
        "application/postscript",
        "application/rdf+xml",
        "application/rss+xml",
        "application/font-woff",
        "application/x-yaml",
        "application/xhtml+xml",
        "application/xop+xml",
        "application/xml",
        "application/xop+xml",
        "application/zip",
        "application/gzip",
        "application/x-www-form-urlencoded",
        "audio/basic",
        "audio/L24",
        "audio/mp4",
        "audio/mpeg",
        "audio/ogg",
        "audio/vorbis",
        "audio/vnd.rn-realaudio",
        "audio/vnd.wave",
        "audio/webm",
        "image/gif",
        "image/jpg",
        "image/jpeg",
        "image/pjpeg",
        "image/png",
        "image/svg+xml",
        "image/tiff",
        "message/http",
        "message/imdn+xml",
        "message/partial",
        "message/rfc822",
        "multipart/mixed",
        "multipart/alternative",
        "multipart/related",
        "multipart/form-data",
        "multipart/signed",
        "multipart/encrypted",
        "text/cmd",
        "text/css",
        "text/csv",
        "text/html",
        "text/plain",
        "text/vcard",
        "text/xml"
    ]
};

// Sourced from https://developer.mozilla.org/en-US/docs/Web/HTTP/Status
export const RESPONSE_CODE_DESCRIPTIONS = {
    // 100s
    100: 'This interim response indicates that everything so far is OK and that the client should continue with the request or ignore it if it is already finished.',
    101: 'This code is sent in response to an Upgrade: request header by the client and indicates the protocol the server is switching to. It was introduced to allow migration to an incompatible protocol version, and it is not in common use.',

    // 200s
    200: 'The request has succeeded.',
    201: 'The request has succeeded and a new resource has been created as a result of it. This is typically the response sent after a PUT request.',
    202: 'The request has been received but not yet acted upon. It is non-committal, meaning that there is no way in HTTP to later send an asynchronous response indicating the outcome of processing the request. It is intended for cases where another process or server handles the request, or for batch processing.',
    203: 'This response code means returned meta-information set is not exact set as available from the origin server, but collected from a local or a third party copy. Except this condition, 200 OK response should be preferred instead of this response.',
    204: 'There is no content to send for this request, but the headers may be useful. The user-agent may update its cached headers for this resource with the new ones.',
    205: 'This response code is sent after accomplishing request to tell user agent reset document view which sent this request.',
    206: 'This response code is used because of range header sent by the client to separate download into multiple streams.',
    207: 'A Multi-Status response conveys information about multiple resources in situations where multiple status codes might be appropriate.',
    208: 'Used inside a DAV: propstat response element to avoid enumerating the internal members of multiple bindings to the same collection repeatedly.',
    226: 'The server has fulfilled a GET request for the resource, and the response is a representation of the result of one or more instance-manipulations applied to the current instance.',

    // 300s
    300: 'The request has more than one possible responses. User-agent or user should choose one of them. There is no standardized way to choose one of the responses.',
    301: 'This response code means that URI of requested resource has been changed. Probably, new URI would be given in the response.',
    302: 'This response code means that URI of requested resource has been changed temporarily. New changes in the URI might be made in the future. Therefore, this same URI should be used by the client in future requests.',
    303: 'Server sent this response to directing client to get requested resource to another URI with an GET request.',
    304: 'This is used for caching purposes. It is telling to client that response has not been modified. So, client can continue to use same cached version of response.',
    305: 'This means requested response must be accessed by a proxy. This response code is not largely supported because of security reasons.',
    306: 'This response code is no longer used and is just reserved currently. It was used in a previous version of the HTTP 1.1 specification.',
    307: 'Server sent this response to directing client to get requested resource to another URI with same method that used prior request. This has the same semantic than the 302 Found HTTP response code, with the exception that the user agent must not change the HTTP method used: if a POST was used in the first request, a POST must be used in the second request.',
    308: 'This means that the resource is now permanently located at another URI, specified by the Location: HTTP Response header. This has the same semantics as the 301 Moved Permanently HTTP response code, with the exception that the user agent must not change the HTTP method used: if a POST was used in the first request, a POST must be used in the second request.',

    // 400s
    400: 'This response means that the server could not understand the request due to invalid syntax.',
    401: 'Authentication is needed to get the requested response. This is similar to 403, but is different in that authentication is possible.',
    402: 'This response code is reserved for future use. Initial aim for creating this code was using it for digital payment systems, but it is not used currently.',
    403: 'Client does not have access rights to the content, so the server is rejecting to give proper response.',
    404: 'Server cannot find requested resource. This response code is probably the most famous one due to how frequently it occurs on the web.',
    405: 'The request method is known by the server but has been disabled and cannot be used.',
    406: "This response is sent when the web server, after performing server-driven content negotiation, doesn't find any content following the criteria given by the user agent.",
    407: 'This is similar to 401 but authentication is needed to be done by a proxy.',
    408: 'This response is sent on an idle connection by some servers, even without any previous request by the client. It means that the server would like to shut down this unused connection. This response is used much more since some browsers, like Chrome or IE9, use HTTP pre-connection mechanisms to speed up surfing (see bug 881804, which tracks the future implementation of such a mechanism in Firefox). Also, note that some servers merely shut down the connection without sending this message.',
    409: 'This response is sent when a request conflicts with the current state of the server.',
    410: 'This response is sent when the requested content has been deleted from the server.',
    411: 'Server rejected the request because the Content-Length header field is not defined and the server requires it.',
    412: 'The client has indicated preconditions in its headers which the server does not meet.',
    413: 'Request entity is larger than limits defined by the server; the server might close the connection or return a Retry-After header field.',
    414: 'The URI requested by the client is longer than the server is willing to interpret.',
    415: 'The media format of the requested data is not supported by the server, so the server is rejecting the request.',
    416: "The range specified by the Range header field in the request can't be fulfilled; it's possible that the range is outside the size of the target URI's data.",
    417: "This response code means the expectation indicated by the Expect request header field can't be met by the server.",
    418: 'Any attempt to brew coffee with a teapot should result in the error code "418 I\'m a teapot". The resulting entity body MAY be short and stout.',
    421: 'The request was directed at a server that is not able to produce a response. This can be sent by a server that is not configured to produce responses for the combination of scheme and authority that are included in the request URI.',
    422: 'The request was well-formed but was unable to be followed due to semantic errors.',
    423: 'The resource that is being accessed is locked.',
    424: 'The request failed due to failure of a previous request.',
    426: 'The server refuses to perform the request using the current protocol but might be willing to do so after the client upgrades to a different protocol. The server MUST send an Upgrade header field in a 426 response to indicate the required protocol(s) (Section 6.7 of [RFC7230]).',
    428: "The origin server requires the request to be conditional. Intended to prevent \"the 'lost update' problem, where a client GETs a resource's state, modifies it, and PUTs it back to the server, when meanwhile a third party has modified the state on the server, leading to a conflict.\"",
    429: 'The user has sent too many requests in a given amount of time ("rate limiting").',
    431: 'The server is unwilling to process the request because its header fields are too large. The request MAY be resubmitted after reducing the size of the request header fields.',
    451: 'The user requests an illegal resource, such as a web page censored by a government.',

    // 500s
    500: "The server has encountered a situation it doesn't know how to handle.",
    501: 'The request method is not supported by the server and cannot be handled. The only methods that servers are required to support (and therefore that must not return this code) are GET and HEAD.',
    502: 'This error response means that the server, while working as a gateway to get a response needed to handle the request, got an invalid response.',
    503: 'The server is not ready to handle the request. Common causes are a server that is down for maintenance or that is overloaded. Note that together with this response, a user-friendly page explaining the problem should be sent. This responses should be used for temporary conditions and the Retry-After: HTTP header should, if possible, contain the estimated time before the recovery of the service. The webmaster must also take care about the caching-related headers that are sent along with this response, as these temporary condition responses should usually not be cached.',
    504: 'This error response is given when the server is acting as a gateway and cannot get a response in time.',
    505: 'The HTTP version used in the request is not supported by the server.',
    506: 'The server has an internal configuration error: transparent content negotiation for the request results in a circular reference.',
    507: 'The server has an internal configuration error: the chosen variant resource is configured to engage in transparent content negotiation itself, and is therefore not a proper end point in the negotiation process.',
    508: 'The server detected an infinite loop while processing the request.',
    510: 'Further extensions to the request are required for the server to fulfill it.',
    511: 'The 511 status code indicates that the client needs to authenticate to gain network access.',
};
