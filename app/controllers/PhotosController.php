<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PhotosController extends BaseController {

    public function index()
    {
        $photos = [];
        return View::make('photos/index')->with('photos', $photos);
    }

    public function upload()
    {
        if (!Input::file('photo')) {
            return View::make('photos/upload');
        }
        // now validate the input
        $data = Input::all();
        /** @var cram\validators\ValidatorLocator $validators */
        $validators = App::make('cram\Validation');
        /** @var cram\validators\SignupValidator $validator */
        $errors = $validators->get('Photo', $data)->errors();
        if ($errors->count()) {
            return View::make('photos/upload')->with('errors', $errors);
        }
        $photo = new Photo();
        $photo->user = Auth::id();
        $photo->title = $data['title'];
        $photo->caption = $data['caption'];
        $photo->filename = $photo::persist($data['photo']);
        $photo->save();
        return Redirect::route('photo', ['id' => $photo->id]);
    }

    public function raw($id)
    {
        $photo = Photo::findOrFail($id);
        $response = Response::make(
            File::get($photo->getPath()),
            200
        )->header(
            'content-type',
            $photo->getMimeType()
        );
        return $response;
    }

    public function view($id)
    {
        try {
            return View::make('photos/view')
                ->with('photo', Photo::findOrFail($id))
                ->with('commentError', Session::pull('comment_error'));
        } catch (ModelNotFoundException $e) {
            return Redirect::route('photos')->with('view_error', 'Photo not found');
        }
    }

    public function delete($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->delete($id);
        return Redirect::route('photos');
    }

    public function like()
    {

    }

    public function comment()
    {
        $data = Input::all();
        /** @var cram\validators\ValidatorLocator $validators */
        $validators = App::make('cram\Validation');
        /** @var cram\validators\SignupValidator $validator */
        $errors = $validators->get('Comment', $data)->errors();
        $redirect = Redirect::route('photo', ['id' => Input::get('id')]);
        if ($errors->count()) {
            $error = $errors->first('text') ? : 'An error occurred while adding your comment';
            // if bad id, ends up 404'ing
            $redirect->with('comment_error', $error);
        } else {
            $comment = new Comment();
            $comment->text = $data['text'];
            $comment->photo = $data['id'];
            $comment->user = Auth::id();
            $comment->save();
        }
        return $redirect;
    }



}
