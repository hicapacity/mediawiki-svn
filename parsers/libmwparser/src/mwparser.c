#include <mwparser.h>
#include <antlr3.h>
#include <mwparsercontext.h>
#include <mwlexercontext.h>

#include "mwWikitextLexer.h"
#include "mwWikitextParser.h"

struct MWPARSER_struct
{
    MWPARSERCONTEXT *parserContext;
    MWLEXERCONTEXT  *lexerContext;
    pANTLR3_COMMON_TOKEN_STREAM tstream;
};

struct MWPARSER_INPUT_STREAM_struct
{
    pANTLR3_INPUT_STREAM antlrStream;
    void *data;
    void (*freeData)(void *);
};

struct MWPARSER_OPTIONS_struct
{
};


MWPARSER *MWParserNew(const MWLISTENER *listener, MWPARSER_INPUT_STREAM *input)
{
    MWPARSER *mwparser = ANTLR3_MALLOC(sizeof(*mwparser));
    if (mwparser == NULL) {
        return NULL;
    }
    mwparser->parserContext = NULL;
    mwparser->lexerContext  = NULL;
    mwparser->tstream       = NULL;

    pmwWikitextLexer lexer = mwWikitextLexerNew(input->antlrStream);
    if (lexer == NULL) {
        MWParserFree(mwparser);
        return NULL;
    }

    mwparser->lexerContext = MWLexerContextNew(lexer->pLexer);
    if (mwparser->lexerContext == NULL) {
        MWParserFree(mwparser);
        return NULL;
    }
    mwparser->tstream = antlr3CommonTokenStreamSourceNew(ANTLR3_SIZE_HINT, TOKENSOURCE(lexer));
    if (mwparser->tstream == NULL) {
        MWParserFree(mwparser);
        return NULL;
    }

    pmwWikitextParser parser = mwWikitextParserNew(mwparser->tstream);
    if (parser == NULL) {
        MWParserFree(mwparser);
        return NULL;
    }

    mwparser->parserContext = MWParserContextNew(parser, listener, mwparser->lexerContext);
    if (mwparser->parserContext == NULL) {
        MWParserFree(mwparser);
        return NULL;
    }

    return mwparser;
}

void MWParserFree(MWPARSER *parser)
{
    if (parser->tstream != NULL) {
        parser->tstream->free(parser->tstream);
    }
    if (parser->parserContext != NULL) {
        parser->parserContext->free(parser->parserContext);
    }
    if (parser->lexerContext != NULL) {
        parser->lexerContext->free(parser->lexerContext);
    }
    ANTLR3_FREE(parser);
}

void MWParserReset(MWPARSER *parser, MWPARSER_INPUT_STREAM *inputStream)
{
    parser->parserContext->reset(parser->parserContext);
    parser->lexerContext->reset(parser->lexerContext);
    parser->lexerContext->lexer->setCharStream(parser->lexerContext->lexer, inputStream->antlrStream);
}


void MWParserParseArticle(MWPARSER *parser, MWPARSER_OPTIONS *options)
{
    pmwWikitextParser psr = parser->parserContext->parser;
    psr->article(psr);
}

static ANTLR3_UINT32 antlr3encoding(MWPARSER_ENCODING encoding)
{
    switch (encoding) {
    case MWPARSER_8BIT:
        return ANTLR3_ENC_8BIT;
    case MWPARSER_UTF8:
        return ANTLR3_ENC_UTF8;
    case MWPARSER_UTF16:
        return ANTLR3_ENC_UTF16;
    case MWPARSER_UTF16LE:
        return ANTLR3_ENC_UTF16LE;
    case MWPARSER_UTF16BE:
        return ANTLR3_ENC_UTF16BE;
    case MWPARSER_UTF32:
        return ANTLR3_ENC_UTF32;
    case MWPARSER_UTF32LE:
        return ANTLR3_ENC_UTF32LE;
    case MWPARSER_UTF32BE:
        return ANTLR3_ENC_UTF32BE;
    default:
        return -1;
    }
}

MWPARSER_INPUT_STREAM *
MWParserOpenString(char *name, char *string, size_t size, MWPARSER_ENCODING encoding)
{
    MWPARSER_INPUT_STREAM *stream = ANTLR3_MALLOC(sizeof(*stream));
    if (stream == NULL) {
        return NULL;
    }
    stream->data = NULL;
    stream->freeData = NULL;
    ANTLR3_UINT32 enc = antlr3encoding(encoding);
    if (enc == (ANTLR3_UINT32)-1) {
        ANTLR3_FREE(stream);
        return NULL;
    }
    stream->antlrStream = antlr3StringStreamNew((pANTLR3_UINT8)string, enc, size, (pANTLR3_UINT8)name);
    return stream;
}

MWPARSER_INPUT_STREAM *
MWParserOpenStringWithCleanup(char *name, char *string, size_t size, MWPARSER_ENCODING encoding, void *data, void (*freeData)(void *))
{
    MWPARSER_INPUT_STREAM *stream = MWParserOpenString(name, string, size, encoding);
    stream->data = data;
    stream->freeData = freeData;
    return stream;
}

MWPARSER_INPUT_STREAM *
MWParserOpenFile(char *fileName, MWPARSER_ENCODING encoding)
{
    MWPARSER_INPUT_STREAM *stream = ANTLR3_MALLOC(sizeof(*stream));
    if (stream == NULL) {
        return NULL;
    }
    ANTLR3_UINT32 enc = antlr3encoding(encoding);
    if (enc == (ANTLR3_UINT32)-1) {
        ANTLR3_FREE(stream);
        return NULL;
    }
    stream->antlrStream  = antlr3FileStreamNew((pANTLR3_UINT8)fileName, enc);
    stream->data = NULL;
    stream->freeData = NULL;
    if (stream->antlrStream == NULL) {
        ANTLR3_FREE(stream);
        return NULL;
    }

    return stream;
}

void
MWParserCloseInputStream(MWPARSER_INPUT_STREAM * inputStream)
{
    inputStream->antlrStream->close(inputStream->antlrStream);
    if (inputStream->freeData != NULL) {
        inputStream->freeData(inputStream->data);
    }
    ANTLR3_FREE(inputStream);
}


bool
MWParserSetLegalTitleRegexp(MWPARSER *parser, const char *perlRegexp)
{
    return parser->lexerContext->setLegalTitleRegexp(parser->lexerContext, perlRegexp);
}

bool
MWParserSetMediaLinkTitleRegexp(MWPARSER *parser, const char *perlRegexp)
{
    return parser->lexerContext->setMediaLinkTitleRegexp(parser->lexerContext, perlRegexp);
}

bool
MWParserRegisterTagExtension(MWPARSER *parser, const MWPARSER_TAGEXT *tagExtension)
{
    return parser->lexerContext->registerTagExtension(parser->lexerContext, tagExtension);
}

void *
MWParserGetResult(MWPARSER *parser)
{
    return parser->parserContext->listener.getResult(&parser->parserContext->listener);
}
