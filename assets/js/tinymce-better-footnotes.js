(function (tinymce) {
  tinymce.PluginManager.add("betterFootnotes", function (ed) {
    ed.addButton("bfn_footnote", {
      title: ed.getLang("betterFootnotes.insertFootnoteTitle", "Insert Footnote"),
      cmd: "bfn_insert_footnote_cmd",
      icon: "dashicon dashicons-book-alt",
    });

    ed.addCommand("bfn_insert_footnote_cmd", function () {
      var selectedContent = ed.selection.getContent({
        format: "html",
      });
      ed.windowManager.open({
        title: ed.getLang("betterFootnotes.insertFootnoteTitle", "Insert Footnote"),
        body: [
          {
            type: "textbox",
            name: "content",
            value: selectedContent,
            multiline: true,
            minWidth: 300,
            minHeight: 100,
          },
        ],
        onsubmit: function (e) {
          var content = "[footnote]" + e.data.content + "[/footnote]";
          ed.execCommand("mceInsertContent", false, content);
        },
      });
    });
  });
})(tinymce);
