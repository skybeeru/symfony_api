<?php


namespace App\Controller;

use App\Entity\Fails;
use App\Entity\Image;
use App\Service\ImageProcessor;
use App\Utils\Base64Image;
use App\Utils\UrlImage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImageController extends AbstractController
{
    /**
     * @Route("/api/images", methods={"POST"})
     */
    public function upload(Request $request, ImageProcessor $processor): JsonResponse
    {
        if ($request->headers->get('content-type') == 'application/json'){
            $data = json_decode($request->getContent(),true);
            foreach ($data['images'] as $image){
                $filename = $image['name'];
                if ($data['type'] == 'base64'){
                    $content = Base64Image::extractData($image['content']);
                    $file = new Base64Image($content,$filename);
                } elseif ($data['type'] == 'url') {
                    $file = new UrlImage(file_get_contents($image['content']),$filename);
                } else {
                    return new JsonResponse(['error' => true,'message' => 'Wrong type of content. Please check your params'],400);
                }
                $processor->process($file,$filename);
            }
        } else {
            $files = $request->files->all();
            foreach ($files['images'] as $file){
                $filename = $file->getClientOriginalName();
                $processor->process($file,$filename);
            }
        }

        return new JsonResponse(['some_data' => true]);
    }
    /**
     * @Route("/api/images", methods={"GET","HEAD"})
     */
    public function list(Request $request): JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Image::class);
        $images = $repository->findAll();
        $output = [];
        /** @var Image $image */
        foreach ($images as $image){
            $output[] = [
                $request->getScheme().'://'.$request->getHost().DIRECTORY_SEPARATOR.Image::DIR.$image->getFilename(),
                $image->getWidth(),
                $image->getHeight()
            ];
            $output[] = [
                $request->getScheme().'://'.$request->getHost().DIRECTORY_SEPARATOR.Image::SQR_DIR.$image->getFilename(),
                100,
                100
            ];
            $output[] = [
                $request->getScheme().'://'.$request->getHost().DIRECTORY_SEPARATOR.Image::THUMB_DIR.$image->getFilename(),
                $image->getTWidth(),
                $image->getTHeight()
            ];
        }

        $response = new JsonResponse($output);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return $response;
    }

    /**
     * @Route("/api/fails", methods={"GET","HEAD"})
     */
    public function failList() : JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Fails::class);
        $fails = $repository->findAll();
        $output = [];
        /** @var Fails $fail */
        foreach ($fails as $fail){
            $output[] = [
                $fail->getFilename(),
                $fail->getErrorCode(),
                $fail->getErrorMsg()
            ];
        }

        return new JsonResponse($output);
    }

    /**
     * @Route("/api/image/{filename}", methods={"DELETE"})
     */
    public function delete(string $filename) : JsonResponse
    {
        $repository = $this->getDoctrine()->getRepository(Image::class);
        $entityManager = $this->getDoctrine()->getManager();
        $images = $repository->findBy(['filename' => $filename]);

        foreach ($images as $image){
            $entityManager->remove($image);
        }
        $entityManager->flush();
        $filesystem = new Filesystem();
        $filesystem->remove([
            Image::DIR.$filename,
            Image::SQR_DIR.$filename,
            Image::THUMB_DIR.$filename
        ]);

        return new JsonResponse([
            'success' => true,
            'message' => $filename." was successfully deleted"
        ]);
    }
}