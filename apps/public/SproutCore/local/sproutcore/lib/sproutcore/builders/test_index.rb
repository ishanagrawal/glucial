# ===========================================================================
# Project:   Abbot - SproutCore Build Tools
# Copyright: ©2009 Apple Inc.
#            portions copyright @2006-2011 Strobe Inc.
#            and contributors
# ===========================================================================

require "sproutcore/builders/base"

module SC

  # Builds an HTML files.  This will setup an HtmlContext and then invokes
  # the render engines for each source before finally rendering the layout.
  class Builder::TestIndex < Builder::Base

    def build(dst_path)
      require 'json'
      items = entry[:source_entries].map do |e|
        { "filename" => e[:filename].ext(''), "url" => e[:url] }
      end
      writelines dst_path, [items.to_json]
    end

  end

end
