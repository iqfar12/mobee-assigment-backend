import { Head, Link, useForm } from '@inertiajs/react';
import { ArrowLeft, Upload } from 'lucide-react';
import { index, update } from '@/routes/admin/cars';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useRef, useState } from 'react';

const CAR_TYPES = ['Sedan', 'SUV', 'Hatchback', 'Truck', 'Coupe', 'Convertible', 'Crossover', 'Minivan'] as const;

type Car = {
    id: number;
    brand: string;
    model: string;
    type: string;
    image_url: string;
};

export default function AdminCarEdit({ car }: { car: Car }) {
    const { data, setData, post, processing, errors } = useForm<{
        _method: string;
        brand: string;
        model: string;
        type: string;
        image: File | null;
    }>({
        _method: 'PUT',
        brand: car.brand,
        model: car.model,
        type: car.type,
        image: null,
    });

    const [preview, setPreview] = useState<string | null>(null);
    const fileInputRef = useRef<HTMLInputElement>(null);

    function handleFile(e: React.ChangeEvent<HTMLInputElement>) {
        const file = e.target.files?.[0] ?? null;
        setData('image', file);
        if (preview) URL.revokeObjectURL(preview);
        setPreview(file ? URL.createObjectURL(file) : null);
    }

    function submit(e: React.FormEvent) {
        e.preventDefault();
        post(update({ car: car.id }).url);
    }

    const displayImage = preview ?? car.image_url;

    return (
        <>
            <Head title={`Edit — ${car.brand} ${car.model}`} />

            <div className="flex flex-col gap-6 p-6">
                <div className="flex items-center gap-4">
                    <Button variant="outline" size="sm" asChild>
                        <Link href={index()}>
                            <ArrowLeft className="mr-1 size-4" />
                            Back to Inventory
                        </Link>
                    </Button>
                </div>

                <Card className="max-w-xl">
                    <CardHeader>
                        <CardTitle>
                            Edit — {car.brand} {car.model}
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={submit} className="space-y-5">
                            <div className="grid gap-5 sm:grid-cols-2">
                                <div className="space-y-1.5">
                                    <Label htmlFor="brand">Brand</Label>
                                    <Input
                                        id="brand"
                                        value={data.brand}
                                        onChange={(e) => setData('brand', e.target.value)}
                                    />
                                    <InputError message={errors.brand} />
                                </div>

                                <div className="space-y-1.5">
                                    <Label htmlFor="model">Model</Label>
                                    <Input
                                        id="model"
                                        value={data.model}
                                        onChange={(e) => setData('model', e.target.value)}
                                    />
                                    <InputError message={errors.model} />
                                </div>
                            </div>

                            <div className="space-y-1.5">
                                <Label htmlFor="type">Type</Label>
                                <Select value={data.type} onValueChange={(v) => setData('type', v)}>
                                    <SelectTrigger id="type">
                                        <SelectValue />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {CAR_TYPES.map((t) => (
                                            <SelectItem key={t} value={t}>
                                                {t}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>
                                <InputError message={errors.type} />
                            </div>

                            <div className="space-y-1.5">
                                <Label htmlFor="image">Car Image</Label>
                                <div
                                    className="flex cursor-pointer flex-col items-center justify-center rounded-md border-2 border-dashed border-muted-foreground/30 p-2 transition-colors hover:border-muted-foreground/60"
                                    onClick={() => fileInputRef.current?.click()}
                                >
                                    {displayImage ? (
                                        <img
                                            src={displayImage}
                                            alt="Preview"
                                            className="h-40 w-full rounded-md object-cover"
                                            onError={(e) => (e.currentTarget.style.display = 'none')}
                                        />
                                    ) : (
                                        <div className="flex flex-col items-center gap-2 py-4 text-muted-foreground">
                                            <Upload className="size-8" />
                                            <span className="text-sm">Click to upload an image</span>
                                            <span className="text-xs">PNG, JPG, WEBP up to 4 MB</span>
                                        </div>
                                    )}
                                </div>
                                <input
                                    ref={fileInputRef}
                                    id="image"
                                    type="file"
                                    accept="image/*"
                                    className="hidden"
                                    onChange={handleFile}
                                />
                                {preview && (
                                    <button
                                        type="button"
                                        className="text-xs text-muted-foreground underline"
                                        onClick={() => {
                                            setData('image', null);
                                            URL.revokeObjectURL(preview);
                                            setPreview(null);
                                            if (fileInputRef.current) fileInputRef.current.value = '';
                                        }}
                                    >
                                        Remove new image (keep existing)
                                    </button>
                                )}
                                <p className="text-xs text-muted-foreground">Leave empty to keep the current image.</p>
                                <InputError message={errors.image} />
                            </div>

                            <div className="flex gap-3">
                                <Button type="submit" disabled={processing}>
                                    {processing ? 'Saving…' : 'Save Changes'}
                                </Button>
                                <Button variant="outline" asChild>
                                    <Link href={index()}>Cancel</Link>
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </>
    );
}
