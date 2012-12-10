Notice
======

The library is under active development. API may change without notice.

What is Markdown?
=================

Markdown is a text-to-HTML conversion tool for web writers.
It is intended to be as easy-to-read and easy-to-write as is feasible.

Readability, however, is emphasized above all else.
A Markdown-formatted document should be publishable as-is, as plain text,
without looking like it’s been marked up with tags or formatting instructions.

See [official website](http://daringfireball.net/projects/markdown/syntax) for syntax.


What is markdown-oo-php?
========================

It's an object-oriented PHP library capable of converting markdown text to XHTML.


Quick start
=========

Library has two entities: _Text_ and _Filter_
_Text_ represents a piece of text.
_Filter_ is responsible for actual transformation.
_Text_ is passed through filters resulting into html output.

    require_once 'Markdown/Text.php';

    echo new \Markdown\Text($markdown);

FAQ
===

#### Can your library process very large documents?

Yes. There is known problem with other markdown implementations when PCRE engine fails with very large files.
My library parses input line by line, so as long as you keep lines less than ~1M you'll be okay.

Requirements
===========

  *  PHP  >= 5.3

Contribution
==========

  1.  [Fork me](https://github.com/garygolden/markdown-oo-php)
  2.  [Mail me](mailto:max@garygolden.me)

http://www.garygolden.me
