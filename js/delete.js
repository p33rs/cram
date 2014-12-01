function Deleter(list) {
    this.list = $(list);
    this.request = null;
    if (!this.list.is('.photo_list')) {
        throw new Error ('expected cramlist');
    }
    this.list.on('click', '.photo_item-delete', this.deletePhoto.bind(this));
}

Deleter.prototype.deletePhoto = function(e) {
    e.preventDefault();
    if (this.request) {
        return;
    }
    var element = $(e.currentTarget).closest('.photo_item');
    console.log(element);
    this.request = $.ajax({
        url: element.find('.photo_item-delete').attr('href'),
        type: 'POST',
        data: { id: element.data('id') },
        error:function() {
            this.error();
        }.bind(this),
        success: function(data) {
            if (!data.success) {
                this.error(data.error);
            } else {
                this.success( element.find('.photo_item-title').text() )
                element.remove();
            }
        }.bind(this),
        complete: function() {
            this.request = null;
        }.bind(this)
    });
};

/**
 * lol o rly?
 * @param error
 */
Deleter.prototype.error = function(error) {
    if (!error) {
        error = 'A problem occurred.';
    }
    alert(error);
    // lol ya rly
};

Deleter.prototype.success = function(image) {
    alert('Image deleted: ' + image);
};


$(function() {
    if ($('.photo_list').length) {
        new Deleter($('.photo_list'));
    }
});