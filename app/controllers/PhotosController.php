<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PhotosController extends BaseController {

    public function index($username = null)
    {
        if ($username) {
            $user = User::where('username', '=', $username)->first();
            if (!$user) {
                return Redirect::route('photos')->with('error', 'User not found.');
            }
            $photos = Photo::where('user', '=', $user->id);
        } else {
            $photos = Photo::all();
        }
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
                ->with('deleteError', Session::pull('delete_error'))
                ->with('commentError', Session::pull('comment_error'));
        } catch (ModelNotFoundException $e) {
            return Redirect::route('photos')->with('error', 'Photo not found');
        }
    }

    public function delete($id)
    {
        $photo = Photo::find($id);
        $error = '';
        if (!$photo) {
            $error = 'Photo not found';
        } elseif ($photo->getUser->id != Auth::id()) {
            $error = 'That\'s not your photo! You can\'t uncram that!';
        } else {
            $photo->delete($id);
            File::delete($photo->getPath());
        }
        if (Request::isMethod('post')) {
            $result = [ 'success' => !$error, 'error' => $error ];
            return Response::json($result);
        } elseif ($error && $photo) {
            $redirect = Redirect::route('photo', ['id' => $id])->with('error', $error);
        } elseif ($error) {
            $redirect = Redirect::route('photos')->with('error', $error);
        } else {
            $redirect = Redirect::route('photos')->with('message', 'Photo deleted.');
        }
        return $redirect;
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
